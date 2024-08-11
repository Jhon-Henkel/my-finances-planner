package consumer

import (
	"github.com/Jhon-Henkel/my-finances-planner/consumer-go/infra/error_hanlder"
	"github.com/streadway/amqp"
	"log"
)

func Consume(queueName string, ch *amqp.Channel) {
	msgs, err := ch.Consume(queueName, "", false, false, false, false, nil)
	error_hanlder.FailOnError(err, "Failed to register a consumer for queue "+queueName)

	go func() {
		for msg := range msgs {
			err := processMessage(msg.Body, queueName)
			if err != nil {
				// print url item on log
				log.Printf("Failed to process: %s", msg.Body)
				msg.Nack(false, false)
			} else {
				// print url item on log
				log.Printf("Success to process: %s %s", msg.Body, queueName)
				msg.Ack(false)
			}
		}
	}()
}

func processMessage(body []byte, queueName string) error {
	log.Printf("Processing message in queue: %s", queueName)
	// Implement your message processing logic here
	return nil
}
