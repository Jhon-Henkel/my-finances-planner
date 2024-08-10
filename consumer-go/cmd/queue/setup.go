package queue

import (
	"github.com/Jhon-Henkel/my-finances-planner/consumer-go/infra/error_hanlder"
	"github.com/streadway/amqp"
)

func Setup(queueName string, ch *amqp.Channel) {
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
	error_hanlder.FailOnError(err, "Failed to declare the dead-letter exchange")

	// Dead Letter Queue
	dlqName := queueName + "_dead"
	_, err = ch.QueueDeclare(
		dlqName, true, false, false, false, nil,
	)
	error_hanlder.FailOnError(err, "Failed to declare the dead-letter queue")

	// Bind Dead Letter Queue to Dead Letter Exchange
	err = ch.QueueBind(dlqName, dlqName, dlxName, false, nil)
	error_hanlder.FailOnError(err, "Failed to bind the dead-letter queue to the exchange")

	// Main Queue
	mainQueueArgs := amqp.Table{
		"x-dead-letter-exchange":    dlxName, // Routing to DLX
		"x-dead-letter-routing-key": dlqName, // Routing key for DLQ
	}
	_, err = ch.QueueDeclare(
		queueName, true, false, false, false, mainQueueArgs,
	)
	error_hanlder.FailOnError(err, "Failed to declare the main queue")
}
