# 🌍 Ovijatrik – Charity Management System

Ovijatrik is a **charity & donation management web application** for NGOs and nonprofit organizations.
The system supports **member-based donations**, **project-wise donations**, **expense management**, and **financial reporting** with multi-account transactions.
---

## ✨ Features

- 👥 Member & Normal Donor system  
- ✅ Member registration, verification & approval  
- 🔐 Member login with personal dashboard  
- 💰 Donation management (membership & project-wise)  
- 🏦 Multi-account transactions (Cash, bKash, Nagad, Rocket, Bank)  
- 📊 Expense management (organization, project, salary)  
- 📁 Project management & completion tracking  
- 🧾 Reports, invoices & admin dashboard  
- 🌐 Public website (Home, Projects, Blog, Contact)

---

## 🛠 Tech Stack

- **Backend:** Laravel 10 (PHP)
- **Frontend:** Vue.js, Tailwind CSS
- **Database:** MySQL
- **Others:** JavaScript, jQuery, HTML, CSS

---

## 🚀 Installation

```bash
git clone https://github.com/mahmodul44/ovijatrik.git
cd ovijatrik
composer install
npm install && npm run dev
cp .env.example .env
php artisan key:generate
php artisan migrate
php artisan serve
