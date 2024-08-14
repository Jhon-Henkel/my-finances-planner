package error_hanlder

import "log"

func FailOnError(err error, msg string) {
	if err != nil {
		log.Fatalf("[ERROR] %s: %s", msg, err)
	}
}
