package queue

import (
	"github.com/Jhon-Henkel/my-finances-planner/consumer-go/infra/error_hanlder"
	"github.com/streadway/amqp"
)

func Setup(queueName string, ch *amqp.Channel) {
	// Dead Letter Exchange
	dlxName := queueName + "_dlx"
	err := ch.ExchangeDeclare(dlxName, "direct", true, false, false, false, nil)
	error_hanlder.FailOnError(err, "Failed to declare the dead-letter exchange to queue "+queueName)

	// Dead Letter Queue
	dlqName := queueName + "_dead"
	_, err = ch.QueueDeclare(dlqName, true, false, false, false, nil)
	error_hanlder.FailOnError(err, "Failed to declare the dead-letter queue to queue "+queueName)

	// Bind Dead Letter Queue to Dead Letter Exchange
	err = ch.QueueBind(dlqName, dlqName, dlxName, false, nil)
	error_hanlder.FailOnError(err, "Failed to bind the dead-letter queue to the exchange to queue "+queueName)

	queueArgs := amqp.Table{
		"x-dead-letter-exchange":    dlxName,
		"x-dead-letter-routing-key": dlqName,
	}
	_, err = ch.QueueDeclare(queueName, true, false, false, false, queueArgs)
	error_hanlder.FailOnError(err, "Failed to declare the queue "+queueName)
}
