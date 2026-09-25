# Personal Task Manager

Project Code: WST21-PM-2026-SF
Student Name: Kelsie Approvechado
Course & Year: BSIT-2 Section-
Database Used: SQLite

## Features
- Add Task
- View Tasks
- Edit Task
- Delete Task
- Update Status

### Additional features
- Filter tasks by All / Pending / Completed (with counts)
- Overdue tasks are highlighted
- One-click status toggle (Pending / Completed)
- Form validation with error messages
- Confirmation before deleting

## Built with
Laravel, Routes, Controller, Model, Blade Views, SQLite

## How to run
1. `composer install`
2. `cp .env.example .env` then `php artisan key:generate`
3. `.env` uses SQLite by default (`DB_CONNECTION=sqlite`), so no database setup is needed
4. `php artisan migrate` (answer yes if it asks to create the database file)
5. `php artisan serve` and open the forwarded URL

## Screenshots
(Add screenshots of your app here.)