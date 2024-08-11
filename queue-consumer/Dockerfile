FROM golang:1.21.1 AS build

WORKDIR /src
COPY ./queue-consumer/go.mod ./queue-consumer/go.sum ./
RUN go mod download
COPY ./queue-consumer .

RUN CGO_ENABLED=0 GOOS=linux go build -a -installsuffix cgo -o main .

FROM alpine:3.18

COPY --from=build /src/main /main
COPY ./queue-consumer/.env .

RUN apk --no-cache add wget
ENV DOCKERIZE_VERSION v0.6.1
RUN wget https://github.com/jwilder/dockerize/releases/download/$DOCKERIZE_VERSION/dockerize-linux-amd64-$DOCKERIZE_VERSION.tar.gz \
    && tar -C /usr/local/bin -xzvf dockerize-linux-amd64-$DOCKERIZE_VERSION.tar.gz \
    && rm dockerize-linux-amd64-$DOCKERIZE_VERSION.tar.gz
