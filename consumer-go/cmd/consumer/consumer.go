package consumer

import (
	"github.com/Jhon-Henkel/my-finances-planner/consumer-go/infra/error_hanlder"
	"github.com/streadway/amqp"
	"log"
)

func Consume(queueName string, ch *amqp.Channel) {
	msgs, err := ch.Consume(
		queueName, "", false, false, false, false, nil,
	)
	error_hanlder.FailOnError(err, "Failed to register a consumer for queue "+queueName)

	go func() {
		for msg := range msgs {
			err := processMessage(msg.Body)
			if err != nil {
				log.Printf("Failed to process: %s", msg.Body)
				msg.Nack(false, false) // Negative acknowledgment
			} else {
				log.Printf("Success to process: %s %s", msg.Body, queueName)
				msg.Ack(false)
			}
		}
	}()
}

func processMessage(body []byte) error {
	log.Printf("Processing message: %s", body)
	// Implement your message processing logic here
	return nil
}
