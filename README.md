# Laravel Task Manager

A simple Laravel web app to manage tasks by project. You can create, delete, and reorder tasks with drag-and-drop — all grouped under projects.

---

## ✅ Features

-   Add, delete, and reorder tasks
-   Tasks are grouped by projects
-   Drag & drop task sorting (priority updates)
-   Built with clean Laravel MVC structure
-   Works with SQLite or MySQL
-   Simple and modern UI

---

## 🚀 One-Step Setup (Copy & Paste into Terminal)

```bash
cd task-manager
composer install
cp .env.example .env
php artisan key:generate
mkdir -p database
touch database/database.sqlite
php artisan migrate
php artisan tinker --execute="\App\Models\Project::create(['name' => 'Personal']); \App\Models\Project::create(['name' => 'Work']);"
php artisan serve

Then open: http://localhost:8000
⚙️ SQLite Configuration
Make sure your .env file includes the correct absolute path to the SQLite file:
DB_CONNECTION=sqlite
DB_DATABASE=/absolute/path/to/your/project/database/database.sqlite

🖼 Preview
👇 Drag & drop tasks

🎯 Each task belongs to a project

✅ Real-time reorder with success message

🧽 Clean UI with subtle icons and styles

👩‍💻 Created by
Ada Ozge Toptas
Laravel Developer Challenge – 2025
```
