# Docker

## Краткая инструкция по тому, как развернуть окружение

# Установка

1. Клонируйте репозиторий:

```bash
   git clone https://github.com/TeriyakiX/vdocker.git

```
2. Установка docker
```bash
   Установите Docker Destkop или DockerToolBox

```

3. Перейдите в директорию проекта:

```bash
    cd vdocker/docker/
```


# Запуск

1. Создайте .env файл на основе приложенного .env.template


2. Для запуска окружения разработки/прода введите в терминал:

```bash
    Для запуска Development-версии:
      cd dev
      Создайте файл .env на основе .env.template
      docker compose up -d --build
    Для запуска Production-версии:
      cd prod
      Создайте файл .env на основе .env.template
      docker compose up -d --build
```

3. Вы можете работать с запущенным окружением с помощью адреса localhost

```bash
    http://localhost
    Или localhost/ 
    В адресной строке
```

# Environment-переменные

В .env.example описаны следующие переменные окружения:

```bash
    NGINX_PORT=порт для nginx
    POSTGRES_USER=Имя пользователя БД
    POSTGRES_PASSWORD=Пароль пользователя БД
    POSTGRES_DB=Наименование базы данных 
    ADMINER_PORT=порт ADMINER
    POSTGRES_PORT=порт для БД Postgresql
```

# Структура

Существуют следующие директории:

```bash
    dev - папка для подъема development-окружения
    prod - папка для подъема production-окружения
    project - туда мы можем поместить свои проекты
   
```

## Желаю удачи
By Dany