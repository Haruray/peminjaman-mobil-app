
FROM bitnami/laravel:latest

ENV DB_CONNECTION=pgsql
ENV DB_HOST=127.0.0.1
ENV DB_PORT=5432
ENV DB_USERNAME=admin
ENV DB_DATABASE=admin
ENV DB_DATABASE=sampledb
WORKDIR /app
COPY . /app

EXPOSE 8000

CMD ["php", "artisan", "serve", "--host=0.0.0.0", "--port=8000"]