package main

import (
	"github.com/Jhon-Henkel/my-finances-planner/consumer-go/cmd/consumer"
	"github.com/Jhon-Henkel/my-finances-planner/consumer-go/cmd/queue"
	"github.com/Jhon-Henkel/my-finances-planner/consumer-go/cmd/queue_manager"
	"github.com/Jhon-Henkel/my-finances-planner/consumer-go/infra/error_hanlder"
	"github.com/joho/godotenv"
	"github.com/streadway/amqp"
	"log"
)

func main() {
	err := godotenv.Load()
	error_hanlder.FailOnError(err, "Error loading .env file")

	connection := queue_manager.MakeConnection()
	defer func(connection *amqp.Connection) {
		error_hanlder.FailOnError(connection.Close(), "Error to close connection")
	}(connection)

	chanel := queue_manager.MakeChanel(connection)
	defer func(chanel *amqp.Channel) {
		error_hanlder.FailOnError(chanel.Close(), "Error to close chanel")
	}(chanel)

	for _, queueName := range queue.List() {
		queue.Setup(queueName, chanel)
		consumer.Consume(queueName, chanel)
	}

	log.Printf("[*] Waiting for messages. To exit press CTRL+C")
	select {}
}
