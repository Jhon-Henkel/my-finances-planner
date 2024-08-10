package main

import (
	"github.com/streadway/amqp"
	"log"
)

func failOnError(err error, msg string) {
	if err != nil {
		log.Fatalf("%s: %s", msg, err)
	}
}

func processMessage(body []byte) error {
	log.Printf("Processing message: %s", body)
	// Implement your message processing logic here
	return nil
}

func consumeMessages(queueName string, ch *amqp.Channel) {
	msgs, err := ch.Consume(
		queueName, "", false, false, false, false, nil,
	)
	failOnError(err, "Failed to register a consumer for queue "+queueName)

	go func() {
		for d := range msgs {
			err := processMessage(d.Body)
			if err != nil {
				log.Printf("Failed to process: %s", d.Body)
				d.Nack(false, false) // Negative acknowledgment
			} else {
				log.Printf("Success to process: %s", d.Body)
				d.Ack(false) // Positive acknowledgment
			}
		}
	}()
}

func setupQueues(queueName string, ch *amqp.Channel) {
	// Dead Letter Exchange
	dlxName := queueName + "_dlx"
	err := ch.ExchangeDeclare(
		dlxName,
		"direct",
		true,
		false,
		false,
		false,
		nil,
	)
	failOnError(err, "Failed to declare the dead-letter exchange")

	// Dead Letter Queue
	dlqName := queueName + "_dead"
	_, err = ch.QueueDeclare(
		dlqName, true, false, false, false, nil,
	)
	failOnError(err, "Failed to declare the dead-letter queue")

	// Bind Dead Letter Queue to Dead Letter Exchange
	err = ch.QueueBind(dlqName, dlqName, dlxName, false, nil)
	failOnError(err, "Failed to bind the dead-letter queue to the exchange")

	// Main Queue
	mainQueueArgs := amqp.Table{
		"x-dead-letter-exchange":    dlxName, // Routing to DLX
		"x-dead-letter-routing-key": dlqName, // Routing key for DLQ
	}
	_, err = ch.QueueDeclare(
		queueName, true, false, false, false, mainQueueArgs,
	)
	failOnError(err, "Failed to declare the main queue")
}

func main() {
	conn, err := amqp.Dial("amqp://guest:guest@192.168.152.53:5672/")
	failOnError(err, "Failed to connect to RabbitMQ")
	defer conn.Close()

	ch, err := conn.Channel()
	failOnError(err, "Failed to open a channel")
	defer ch.Close()

	setupQueues("create_user", ch)
	consumeMessages("create_user", ch)

	log.Printf(" [*] Waiting for messages. To exit press CTRL+C")
	select {}
}
