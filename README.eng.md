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

The application ensures data validation and enforces business logic while maintaining user data privacy.

---

## ⚙️ Features

* User registration (name, phone, bus selection)
* Input validation
* Duplicate prevention
* Seat limit control per bus
* Real-time seat availability
* Staff information display
* CSV export

---

## 🔒 Data Privacy & Security

* Personal data (names, phone numbers) is **not exposed via public API**
* All sensitive data is stored locally in `/data` directory
* `/data` directory is excluded via `.gitignore`
* Access to `/data` is restricted on the server level
* Public API returns only aggregated data (counts, limits)

---

## 🧠 Backend

* PHP (no frameworks)
* REST API:

  * `GET /api.php?action=state` — public data (no personal info)
  * `POST /api.php?action=submit` — user registration
* JSON-based storage
* CSV export generation
* File locking (`flock`) to prevent race conditions

---

## 🎨 Frontend

* HTML, CSS, Vanilla JavaScript
* Responsive UI
* Fetch API
* Client-side validation
* Real-time phone formatting
* Toast notifications

---

## 🗄️ Data Storage

* JSON — internal storage (not публичный)
* CSV — export format

---

## 🚀 Getting Started

### Requirements

* PHP 8+

---

### Run locally

```bash id="n41o7j"
git clone https://github.com/Rodion-Web/Bus-Registration.git
cd Bus-Registration
php -S localhost:8000
```

Open in browser:
http://localhost:8000

---

### 💡 Notes

* No database required
* Data files are created automatically
* Designed for easy local setup

---

## 📂 Project Structure

```id="6jzv8y"
/data        # ignored (runtime data)
api.php
config.php
function.php
index.html
```

---

## 🌐 Live Demo

https://bus-jewell.ru/

---

## 👨‍💻 Author

Pet project demonstrating fullstack development and backend logic design.

---

## 💡 Future Improvements

* Admin panel with authentication
* Database integration (MySQL/PostgreSQL)
* Rate limiting / anti-spam protection
* Docker support
* Migration to frameworks (Laravel / React)

---
