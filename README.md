# St Alphonsus Primary School Web-Based Management System

This is a web-based back-end system developed for St Alphonsus Primary School as part of a university backend development module. The system is built using **PHP**, **MySQL**, **Apache**, and **Bootstrap**, and allows school administrators to manage pupils, parents, teachers, and classes.

## 📁 Project Structure

- `index.php` – Dashboard / homepage
- `add_pupil.php` – Add new pupils
- `add_parent.php` – Add new parents
- `add_teacher.php` – Add new teachers and assign them to classes
- `add_class.php` – Add new classes
- `assign_parent.php` – Assign a parent to a pupil (only one parent per pupil)
- `db.php` – Database connection script
- `style.css` – Custom styling (if any)
- `README.md` – Project documentation

## 🧱 Database Schema

- `pupil` – Stores pupil information
- `parent` – Stores parent information
- `teacher` – Stores teacher details
- `class` – Each class has one teacher (1:1 relationship)
- `pupil_parent` – Each pupil can have only one parent (1:M relationship)

## ⚙️ How to Set Up

1. **Install XAMPP** or similar local server stack
2. Place the project folder inside `htdocs`
3. Start **Apache** and **MySQL** via XAMPP
4. Open **phpMyAdmin** and run the provided SQL script to create the database and tables
5. Import dummy data if included
6. Access the app via `http://localhost/st_alphonsus`

## 💡 Features

- Add pupils, teachers, parents, and classes
- Assign teachers to classes (one teacher per class)
- Assign parents to pupils (one parent per pupil)
- View styled forms and homepage
- Validations to prevent duplicate assignments

## 🔐 Tech Stack

- PHP
- MySQL
- HTML5 / CSS3
- Apache (XAMPP)



