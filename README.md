# 🚌 Система регистрации на автобусы

![PHP](https://img.shields.io/badge/PHP-8.x-blue)
![JavaScript](https://img.shields.io/badge/JavaScript-Vanilla-yellow)
![Status](https://img.shields.io/badge/status-active-success)
![License](https://img.shields.io/badge/license-MIT-green)

<p align="center">
  🇷🇺 Русский | <a href="README.eng.md">🇬🇧 English</a>
</p>

---

## 📌 Описание

Веб-приложение для регистрации пользователей на автобусные рейсы с учетом ограничений мест и защитой от дублирующих записей.

---

## ⚙️ Функционал

* Регистрация пользователя (ФИО, телефон, автобус)
* Валидация данных
* Предотвращение дубликатов
* Контроль количества мест
* Просмотр списков пассажиров
* Отображение персонала
* Экспорт данных в CSV

---

## 🧠 Backend

* PHP (без фреймворков)
* REST API:

  * `GET /api.php?action=state`
  * `POST /api.php?action=submit`
* Хранение данных в JSON
* Защита от race condition (`flock`)

---

## 🎨 Frontend

* HTML, CSS, Vanilla JavaScript
* Адаптивный интерфейс
* Работа через fetch API
* Валидация на клиенте
* Уведомления

---

## 🚀 Запуск

### Требования

* PHP 8+

### Локальный запуск

```bash
git clone https://github.com/Rodion-Web/Bus-Registration.git
cd Bus-Registration
php -S localhost:8000
```

Открыть в браузере:
http://localhost:8000

---

## 📂 Структура проекта

```
/data
api.php
config.php
function.php
index.html
```

---

## 👨‍💻 Автор

Pet-проект для демонстрации навыков fullstack-разработки
