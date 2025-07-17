# Laravel Order Processing App (Transaction + Job + Bootstrap UI)

A modern Laravel 10-based Order Processing application with transactional order creation and background job processing. This project demonstrates the use of database transactions, asynchronous job queues, and a responsive Bootstrap 5 UI for placing orders with multiple products.

---

## 📁 Features

- Create orders with multiple products
- Store orders and items in one database transaction
- Rollback on failure to ensure data integrity
- Background job processing using Laravel queues
- Bootstrap 5-based responsive order form UI
- Add/Remove product rows dynamically
- Validation and error handling
- Clean folder structure following Laravel standards

---

## 🖼️ Screenshot

> *(Add your screenshot here using drag & drop in GitHub or markdown link)*  
> Example:  
> `![Order Form Screenshot](screenshot.png)`

---

## 🚀 Tech Stack

- Laravel 10
- MySQL
- Bootstrap 5
- Laravel Queues (Database driver)
- PHP 8+
- Composer

---

## 🗂️ Folder Structure

Payninja-task/
├── app/
│ ├── Http/Controllers/OrderController.php
│ ├── Jobs/ProcessOrderJob.php
│ └── Models/Order.php, OrderItem.php
├── resources/views/order/create.blade.php
├── routes/web.php
├── database/migrations/
│ ├── create_orders_table.php
│ └── create_order_items_table.php
├── public/
├── .env
├── composer.json
└── README.md


---

## ⚙️ How to Run This Project

### 🖥️ Requirements

- PHP 8.0 or higher
- Composer
- MySQL
- Laravel CLI
- Node.js (optional, for frontend assets)
- Queue worker setup (e.g., terminal or supervisor)

---

### 🔧 Setup Instructions

1. **Clone the Repository**
git clone https://github.com/Bhaskar1308/Payninja-task.git
cd Payninja-task
Install Dependencies


composer install
Create .env File
---


cp .env.example .env
php artisan key:generate
Configure Database in .env
---

env
DB_DATABASE=your_db_name
DB_USERNAME=root
DB_PASSWORD=
QUEUE_CONNECTION=database
---

Run Migrations
php artisan migrate
---

Start Laravel Development Server
php artisan serve
---

Open in browser:
http://127.0.0.1:8000/order/create
---

Start the Queue Worker
php artisan queue:work
---

 MySQL Table Structures
orders Table
--
CREATE TABLE `orders` (
  `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
  `customer_name` VARCHAR(255) NOT NULL,
  `total_amount` DECIMAL(10,2) NOT NULL DEFAULT 0.00,
  `created_at` TIMESTAMP NULL,
  `updated_at` TIMESTAMP NULL,
  PRIMARY KEY (`id`)
);

order_items Table
--
CREATE TABLE `order_items` (
  `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
  `order_id` BIGINT UNSIGNED NOT NULL,
  `product_name` VARCHAR(255) NOT NULL,
  `quantity` INT NOT NULL,
  `price` DECIMAL(10,2) NOT NULL,
  `created_at` TIMESTAMP NULL,
  `updated_at` TIMESTAMP NULL,
  PRIMARY KEY (`id`),
  FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE
);
