## Тестовое задания для kt.team (backend php)

https://kt.team/hr/test-backend

Выполнил art-ps 01.12.2019. Затраченое время ~5 часов.

## Запуск приложения в docker

1. Склонировать себе репозиторий.

```
$ git clone git@github.com:art-ps/ktteam.git
```

2. Перейти в папку с приложением:

```
$ cd ktteam
```

3. Скопировать файл с настройками

```
$ cp .env.docker .env
```

4. Установить зависимости:

```
$ docker-compose run --rm --no-deps ktteam-app composer install
```

5. Запустить приложение. Оно будет доступно по адресу "http://localhost:8000":

```
$ docker-compose up -d
```

6. Для запуска миграций выполнить:

```
$ docker-compose run --rm --no-deps ktteam-app php console.php migrate
```

7. Для заполнения базы тестовыми данными выполнить:

```
$ docker-compose run --rm --no-deps ktteam-app php console.php seed
```

8. Для запуска тестов выполнить:

```
$ cp .env.testing.docker .env.testing
$ docker-compose run --rm ktteam-app ./vendor/bin/phpunit -c ./tests/config.xml --order-by=defects --stop-on-defect
```

# Для запуска приложения без docker'a

1. Склонировать себе репозиторий.

```
$ git clone git@github.com:art-ps/ktteam.git
```

2. Перейти в папку с приложением:

```
$ cd ktteam
```

3. Скопировать файл с настройками

```
$ cp .env.local .env
```

4. В файле .env изменить настройки подключения к БД

5. Создать две базы данных:

```sql
mysql>CREATE DATABASE ktteam;
mysql>CREATE DATABASE testing;
```

6. Установить зависимости:

```
$ composer install
```

7.  Для запуска миграций выполнить:

```
$ php console.php migrate
```

8. Для заполнения базы тестовыми данными выполнить:

```
$ php console.php seed
```

9. В папке приложения выполнить

```
php -S 0.0.0.0:8000 -t web/
```

10. Приложение доступно на http://localhost:8000

11. Для запуска тестов сначала скопировать файл с настройками подключения:

```
$ cp .env.testing.local .env.testing
```

При необходимости изменить настройки подключения к БД в файле , затем запустить тесты:

```
$ ./vendor/bin/phpunit -c ./tests/config.xml --order-by=defects --stop-on-defect
```

## API

В приложении реализованы следующие маршруты:

```
1) 'GET' /task
```

Получить список всех задач.

Результаты можно фильтровать передав в теле запроса JSON с параметрами, например:

`{"status": "planned", "user_id" : 2}`

_выбрать задачи со статусом "planned" и пользователем с id = 2_

Пример ответа:

```json
{
  "status": true,
  "message": [
    {
      "id": 1,
      "name": "Read a book",
      "description": "Find, buy and read \"PHP Internals\" book",
      "status": "planned",
      "user_id": 1,
      "created_at": "2019-11-30 20:19:04",
      "updated_at": "2019-11-30 20:19:04"
    },
    {
      "id": 2,
      "name": "This is new task",
      "description": "This task is just created",
      "status": "planned",
      "user_id": 1,
      "created_at": "2019-11-30 20:19:04",
      "updated_at": "2019-11-30 21:15:35"
    },
    {
      "id": 3,
      "name": "Have a cup of coffee",
      "description": "Go to kitchen and drink a coffee",
      "status": "planned",
      "user_id": 2,
      "created_at": "2019-11-30 20:19:04",
      "updated_at": "2019-11-30 20:19:04"
    }
  ]
}
```

---

```
2) 'GET' /task/{id}
```

Получить задачу по id.

Пример ответа:

```json
{
  "status": true,
  "message": {
    "id": 3,
    "name": "Have a cup of coffee",
    "description": "Go to kitchen and drink a coffee",
    "status": "planned",
    "user_id": 2,
    "created_at": "2019-11-30 20:19:04",
    "updated_at": "2019-11-30 20:19:04",
    "user": {
      "id": 2,
      "name": "Second User",
      "email": "secondemail@example.com",
      "created_at": "2019-11-30 20:19:04",
      "updated_at": "2019-11-30 20:19:04"
    }
  }
}
```

---

```
3) 'POST' /task
```

Создать задачу.

В теле запроса передаётся JSON с параметрами для создания задачи, например:

`{"name" : "This is new task", "description" : "This task is just created", "user_id" : 1}`

Пример ответа:

```json
{
  "status": true,
  "message": {
    "name": "This is new task",
    "description": "This task is just created",
    "user_id": 1,
    "updated_at": "2019-11-30 20:56:23",
    "created_at": "2019-11-30 20:56:23",
    "id": 5
  }
}
```

---

```
4) 'PUT' /task/{id}
```

Редактирование задачи по id.

В теле запроса передаётся JSON с параметрами для редактирования задачи, например:

- поменять имя и описания задачи:

  `{"name" : "This is new name of the task", "description" : "This is new deescription"}`

- поменять статус задачи c "запланирован" на "сделано"

  `{"status" : "done"}`

- поменять пользователя задачи на пользователя с id = 1

  `{"user_id" : 1}`

Пример ответа:

```json
{
  "status": true,
  "message": ["Success"]
}
```

---

```
5) 'DELETE' /task/{id}
```

Удаление задачи по id.

Пример ответа:

```json
{
  "status": true,
  "message": ["Success"]
}
```

---

```
6) 'GET' /user
```

Список пользователей

Пример ответа:

```json
{
  "status": true,
  "message": [
    {
      "id": 1,
      "name": "First User",
      "email": "firstemail@example.com",
      "created_at": "2019-11-30 20:19:04",
      "updated_at": "2019-11-30 20:19:04"
    },
    {
      "id": 2,
      "name": "Second User",
      "email": "secondemail@example.com",
      "created_at": "2019-11-30 20:19:04",
      "updated_at": "2019-11-30 20:19:04"
    }
  ]
}
```

---

# Тестирование маршрутов в Insomnia

Запросы для Insomnia можно импортировать из файла "Insomnia_export.json"

![insomnia](screenshot.jpg? "Insomnia screenshot")
