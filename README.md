# Human Resource Information System (HRIS)
A web-based Human Resource Information System (HRIS) developed for managing employees, departments, attendance, leave, and payroll records. This project is developed as part of the Database Management System (DBMS) course.

# Table of Contents
1. Project Overview
2. Features
3. Technologies Used
4. Project Structure
5. Database Tables
6. Modules
7. Installation Guide
8. Login Credentials
9. CRUD Operations
10. Future Improvements
11. Team Members
12. License

# Project Overview
The Human Resource Information System (HRIS) helps organizations manage employee information digitally. It allows HR staff to maintain employee records, attendance, leave requests, departments, and payroll information efficiently, all behind a secure login.

# Features
- Secure Admin Login with Session-based Authentication
- Protected Pages (login required to access any module)
- Employee Management (CRUD + Search by ID/Name/Department)
- Department Management (CRUD + Search)
- Attendance Management (CRUD)
- Leave Management (CRUD)
- Payroll Management (CRUD with auto-calculated Net Salary)
- Dynamic Dashboard (live employee, department, attendance, and payroll counts)
- Reports Page (department-wise employee count, attendance summary, payroll summary)
- Responsive UI (mobile-friendly layout and tables)
---
# Technologies Used
### Frontend
- HTML5
- CSS3
- Bootstrap
- JavaScript
### Backend
- PHP
### Database
- MySQL
### Server
- XAMPP

# Project Structure              

HRIS-Management-System/
│
├── README.md
├── database_schema.sql
├── index.php
├── dashboard.php
├── login.php
├── logout.php
│
├── config/
│   ├── db.php
│   └── auth_check.php
│
├── docs/
│   ├── ER_Diagram.png.png
│   ├── Flowchart.png.png
│   └── README.md
│
└── pages/
    ├── employees/
    ├── departments/
    ├── attendance/
    ├── leave_management/
    ├── payroll/
    └── reports/             


# Database Tables
- Users
- Departments
- Employees
- Attendance
- Leave_Management
- Payroll
  
# Modules
- Login / Session / Logout / Protected Pages
- Dashboard (dynamic)
- Employee Management
- Department Management
- Attendance Management
- Leave Management
- Payroll Management
- Reports
- Search

# CRUD Operations
✔ Create
✔ Read
✔ Update
✔ Delete

# Installation
### 1. Clone the repository
```bash
git clone https://github.com/fmahi-m/HRIS-Management-System.git
```
### 2. Place the project in your XAMPP htdocs folder
C:\xampp\htdocs\hris

### 3. Import Database
Open phpMyAdmin, create a database named `hris`, and import:

database_schema.sql

### 4. Start Apache and MySQL
### 5. Open the Project

http://localhost/hris/pages/login.php


# Login Credentials
Use the following to log in as Admin:
- **Username:** admin
- **Password:** admin123
  
# Future Improvements
- Employee-level Login (separate from Admin/HR)
- PDF Report Generation
- Email Notifications
- Advanced Dashboard Analytics/Charts
  
# Team Members
- **Fabiha Montaha Mahi** (242-115-057)
- **Anamika Debi** (242-115-068)
  
# License
This project is developed for educational purposes only.

# ER Diagram
![ER Diagram](docs/Untitled.png)

# Flowchart
![Flowchart](docs/Employee Management CRUD-2026-08-06-205....png)
