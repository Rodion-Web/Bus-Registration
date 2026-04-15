# 🚌 Bus Registration System

![PHP](https://img.shields.io/badge/PHP-8.x-blue)
![JavaScript](https://img.shields.io/badge/JavaScript-Vanilla-yellow)
![Status](https://img.shields.io/badge/status-active-success)
![License](https://img.shields.io/badge/license-MIT-green)
![Repo Size](https://img.shields.io/github/repo-size/Rodion-Web/Bus-Registration)
![Last Commit](https://img.shields.io/github/last-commit/Rodion-Web/Bus-Registration)
![Stars](https://img.shields.io/github/stars/Rodion-Web/Bus-Registration?style=social)

Веб-приложение для регистрации пользователей на автобусные рейсы с учетом ограничений мест и предотвращением дублирующих записей.

---

## 📌 Описание

Приложение позволяет пользователям записываться на автобусы, а администраторам — отслеживать загрузку рейсов и управлять списками пассажиров.

Система автоматически проверяет корректность данных, предотвращает дублирование заявок и ограничивает количество мест для каждого автобуса.

---

## ⚙️ Функционал

* Регистрация пользователя (ФИО, телефон, автобус)
* Валидация данных (формат телефона, обязательные поля)
* Предотвращение дубликатов (по ФИО и номеру)
* Контроль лимита мест на автобус
* Отображение оставшихся мест в реальном времени
* Просмотр списка пассажиров по каждому автобусу
* Отображение персонала (staff)
* Уведомления об успешной/ошибочной регистрации
* Экспорт данных в CSV

---

## 🧠 Backend

* PHP (без фреймворков)
* REST API:

  * `GET /api.php?action=state`
  * `POST /api.php?action=submit`
* Работа с JSON как хранилищем
* Генерация CSV-файла
* File locking (`flock`)

---

## 🎨 Frontend

* HTML, CSS, Vanilla JavaScript
* Адаптивный интерфейс
* Работа с API через `fetch`
* Валидация на клиенте
* Форматирование телефона
* Toast-уведомления

---

## 🚀 Запуск

```bash
php -S localhost:8000
```

Открыть: http://localhost:8000

---

## 📂 Структура

```
/data
api.php
config.php
function.php
index.html
```

---

## 👨‍💻 Автор

Pet-проект для демонстрации fullstack-навыков

---
