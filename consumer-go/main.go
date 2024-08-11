package main

import (
	"github.com/Jhon-Henkel/my-finances-planner/consumer-go/cmd/consumer"
	"github.com/Jhon-Henkel/my-finances-planner/consumer-go/cmd/queue"
	"github.com/Jhon-Henkel/my-finances-planner/consumer-go/cmd/queue_manager"
	"github.com/joho/godotenv"
	"log"
)

func main() {
	err := godotenv.Load()
	if err != nil {
		log.Fatalf("Error loading .env file")
	}

	connection := queue_manager.MakeConnection()
	defer connection.Close()

	chanel := queue_manager.MakeChanel(connection)
	defer chanel.Close()

	for _, queueName := range queue.List() {
		queue.Setup(queueName, chanel)
		consumer.Consume(queueName, chanel)
	}

	log.Printf(" [*] Waiting for messages. To exit press CTRL+C")
	select {}
}
