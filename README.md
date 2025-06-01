# 📚 Library Management System (University Project)

This repository contains a simple web-based *Library Management System*, developed as part of a university course requirement. The system allows users to browse and reserve books, while administrators can manage book inventory and handle reservation requests.

> ⚠ *Note: This project was implemented using **PHP and MySQL* due to course requirements, although my primary focus as a developer is *Full-Stack Web Development with Node.js and modern JavaScript frameworks*.

---

## 🧾 Project Summary

This application simulates the essential features of a basic library system. It offers a clear separation between user-facing functionality and administrative tools. Although quickly developed to meet academic deadlines, it serves as a strong representation of backend logic, database interaction, and system modeling in web development.

---

## ✨ Features

### 👤 User Side:
- Browse available books.
- Submit a reservation request for a book.
- View current reservations and their statuses.

### 🛠 Admin Side:
- Add, update, and delete books.
- Upload, update, and delete book cover images.
- View and manage all reservations:
  - Approve or cancel reservations.
  - Confirm whether a book has been returned.

---

## 🧰 Technologies Used

| Component    | Technology           |
|--------------|----------------------|
| Backend      | PHP                  |
| Database     | MySQL                |
| Frontend     | HTML, CSS, JavaScript |
| Architecture | Procedural (MVC-like file structure) |

---

## 🖼 Book Image Management

Each book in the system can have an associated cover image. The image management functionality includes:

- *Uploading Images*: Administrators can upload book cover images, which are stored in the uploads/ directory on the server. The relative path to each image is saved in the corresponding book record in the MySQL database.

- *Updating Images*: When editing a book's details, administrators can replace the existing cover image. The system ensures the old image file is removed from the server to prevent storage clutter.

- *Deleting Images*: Upon deleting a book, its associated image file is also removed from the uploads/ directory, and the corresponding database record is deleted.

This approach optimizes storage by keeping only necessary images and maintains data consistency between the file system and the database.

---

---

## 📌 Important Notes

- This project was developed quickly for an academic course, so the *file structure and code organization are not production-ready*.

- Some *best practices (e.g., clean code, security validations)* may be missing due to time constraints.

- No authentication or user management is included—future versions could implement role-based access control.

- The project can serve as a *foundation for future refactoring, or a **blueprint to be rebuilt using Node.js/Express and MongoDB* in alignment with my current tech stack.

---

## 🔧 Possible Improvements (Future Work)

- Refactor to follow MVC design pattern.
- Implement user login and authentication.
- Apply modern UI/UX practices.
- Add pagination, search, and filtering to book listings.
- Rebuild the project using Node.js and Express.js for the backend.

