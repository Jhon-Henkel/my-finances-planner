package consumer

import (
	"bytes"
	"context"
	"encoding/json"
	"fmt"
	"github.com/Jhon-Henkel/my-finances-planner/consumer-go/infra/error_hanlder"
	"github.com/streadway/amqp"
	"log"
	"net/http"
	"os"
	"time"
)

type QueueData struct {
	Url                  string          `json:"url"`
	Method               string          `json:"method"`
	ExpectedResponseCode int             `json:"expected_response_code"`
	Data                 json.RawMessage `json:"data"`
}

func Consume(queueName string, ch *amqp.Channel) {
	msgs, err := ch.Consume(queueName, "", false, false, false, false, nil)
	error_hanlder.FailOnError(err, "Failed to register a consumer for queue "+queueName)

	go func() {
		for msg := range msgs {
			var queueData QueueData
			err := json.Unmarshal(msg.Body, &queueData)
			if err == nil {
				err = processMessage(queueData)
				if err != nil {
					log.Printf("Failed to process: %s, Error: %s", queueData.Url, err)
					error_hanlder.FailOnError(msg.Nack(false, false), "Error to nack message")
				} else {
					error_hanlder.FailOnError(msg.Ack(false), "Error to ack message")
				}
			} else {
				log.Printf("Error: %s", err)
			}
		}
	}()
}

func processMessage(queueData QueueData) error {
	log.Printf("Prossessing: %s ...", queueData.Url)
	ctx := context.Background()
	ctx, cancel := context.WithTimeout(ctx, 10*time.Second)
	defer cancel()
	req, err := http.NewRequestWithContext(ctx, queueData.Method, queueData.Url, bytes.NewBuffer(queueData.Data))
	if err != nil {
		return err
	}
	req.Header.Set("Content-Type", "application/json")
	req.Header.Set("MFP-TOKEN", os.Getenv("APP_TOKEN"))
	req.Header.Set("user-agent", "mfp-consumer")
	res, err := http.DefaultClient.Do(req)
	if err != nil {
		return err
	}
	defer res.Body.Close()
	if res.StatusCode != queueData.ExpectedResponseCode {
		return fmt.Errorf("expected response code %v but got %v", queueData.ExpectedResponseCode, res.StatusCode)
	}
	log.Printf("Success to process: %s", queueData.Url)
	return nil
}
