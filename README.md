# «Movies Explorer» (Backend: PHP + MySQL)

<div align="center">

▼ ▼ ▼
------------- |
<a href="https://ale-lit.ru/movies-explorer/"><img src="https://github.com/ale-lit/ale-lit/blob/main/screens/movies-explorer.jpg" alt="Movies Explorer"></a>
| <div align="center">**https://ale-lit.ru/movies-explorer/**</div> |

</div>

API реализованное для дипломного проекта «Movies Explorer» в [Яндекс.Практикуме](https://practicum.yandex.ru/ "Сервис онлайн-образования от Яндекса"), переписанное на PHP + MySQL. Оригинальная реализация на связке NodeJS + MongoDB [находится здесь](https://github.com/ale-lit/movies-explorer-api).

Адрес для подключения к сервису: https://ale-lit.ru/movies-explorer-api/api/v1

**Реализованный функционал:**
- Выдача по запросу всех фильмов хранящихся в БД
- Регистрация/авторизация/редактирование пользователей (с валидацией всех полей)
- Добавление/удаление фильмов в базе (с валидацией всех полей)
- Логирование работы сервера

**Роуты:**  
- [GET] /beatfilm-movies - возвращает все фильмы хранящиеся в базе
- [GET] /movies - возвращает все сохранённые текущим пользователем фильмы
- [POST] /movies - сохраняет переданный фильм в сохраненных у текущего пользователя
- [DELETE] /movies/id - удаляет указанный по id фильм из сохраненных у текущего пользователя
- [POST] /signup - создаёт пользователя с переданными в теле email, password и name
- [POST] /signin - проверяет переданные в теле почту и пароль и возвращает токен
- [GET] /users/me - возвращает информацию о пользователе (email и имя)
- [PATCH] /users/me - обновляет информацию о пользователе (email и имя)

## Используемые навыки и технологии
* PHP
* MySQL
* API
* CORS
