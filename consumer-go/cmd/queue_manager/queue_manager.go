package queue_manager

import (
	"github.com/Jhon-Henkel/my-finances-planner/consumer-go/infra/error_hanlder"
	"github.com/streadway/amqp"
)

func MakeConnection() *amqp.Connection {
	conn, err := amqp.Dial("amqp://guest:guest@192.168.152.53:5672/")
	error_hanlder.FailOnError(err, "Failed to connect to RabbitMQ")
	return conn
}

func MakeChanel(conn *amqp.Connection) *amqp.Channel {
	channel, err := conn.Channel()
	error_hanlder.FailOnError(err, "Failed to open a channel")
	return channel
}
