package queue_manager

import (
	"github.com/Jhon-Henkel/my-finances-planner/consumer-go/infra/error_hanlder"
	"github.com/streadway/amqp"
	"os"
)

func MakeConnection() *amqp.Connection {
	conn, err := amqp.Dial(os.Getenv("QUEUE_CONNECTION_URL"))
	error_hanlder.FailOnError(err, "Failed to connect to RabbitMQ")
	return conn
}

func MakeChanel(conn *amqp.Connection) *amqp.Channel {
	channel, err := conn.Channel()
	error_hanlder.FailOnError(err, "Failed to open a channel")
	return channel
}
