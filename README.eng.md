# 🚌 Bus Registration System

![PHP](https://img.shields.io/badge/PHP-8.x-blue)
![JavaScript](https://img.shields.io/badge/JavaScript-Vanilla-yellow)
![Status](https://img.shields.io/badge/status-active-success)
![License](https://img.shields.io/badge/license-MIT-green)
![Repo Size](https://img.shields.io/github/repo-size/Rodion-Web/Bus-Registration)
![Last Commit](https://img.shields.io/github/last-commit/Rodion-Web/Bus-Registration)
![Stars](https://img.shields.io/github/stars/Rodion-Web/Bus-Registration?style=social)

<p align="center">
  🇬🇧 English | <a href="README.ru.md">🇷🇺 Русский</a>
</p>

---

## 📌 Description

A fullstack web application for managing bus registrations with seat limits, real-time availability tracking, and duplicate prevention.

---

## ⚙️ Features

* User registration (name, phone, bus)
* Input validation
* Duplicate prevention
* Seat limit control
* Passenger lists per bus
* Staff display
* CSV export

---

## 🧠 Backend

* PHP (no frameworks)
* REST API:

  * `GET /api.php?action=state`
  * `POST /api.php?action=submit`
* JSON storage
* File locking (`flock`)

---

## 🎨 Frontend

* HTML, CSS, Vanilla JavaScript
* Responsive UI
* Fetch API
* Real-time validation
* Toast notifications

---

## 🚀 Getting Started

### Requirements

* PHP 8+

### Run locally

```bash
git clone https://github.com/Rodion-Web/Bus-Registration.git
cd Bus-Registration
php -S localhost:8000
```

Open in browser:
http://localhost:8000

---

## 📂 Project Structure

```
/data
api.php
config.php
function.php
index.html
```

---

## 🌐 Live Demo

Coming soon...

---

## 👨‍💻 Author

Pet project for demonstrating fullstack development skills
