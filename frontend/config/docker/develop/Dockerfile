FROM node:24-alpine

WORKDIR /app

COPY ../../../.. .

COPY ./config/docker/develop/entrypoint.sh /entrypoint.sh
RUN chmod +x /entrypoint.sh

EXPOSE 3000

ENTRYPOINT ["/entrypoint.sh"]

CMD ["npm", "run", "dev"]
