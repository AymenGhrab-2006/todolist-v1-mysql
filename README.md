# ToDo List v1 (PHP + MySQL)

A simple, single-user ToDo list app built with plain PHP, MySQL, and Tailwind CSS. Tasks are stored in a MySQL database and rendered server-side; add/edit/delete actions post back to a small PHP controller.

## Features

- Add, modify, and delete tasks (title + description)
- Server-rendered task list with rotating color themes per card
- Modal dialogs (native `<dialog>`) for adding/editing, styled with a blurred backdrop
- Client-side length checks (title ≤ 30 chars, description ≤ 255 chars) mirrored by server-side column limits

## Tech Stack

- **Frontend:** PHP-rendered HTML, Tailwind CSS (compiled locally from `input.css`), vanilla JavaScript
- **Backend:** PHP (`mysqli`, prepared statements)
- **Database:** MySQL / MariaDB

## Requirements

- PHP 8+ with the `mysqli` extension
- MySQL or MariaDB server (tested against MariaDB via XAMPP)
- A local web server capable of running PHP (e.g. XAMPP, MAMP, or `php -S`)

## Setup

1. **Create the database.**
   Import the schema into your MySQL/MariaDB server:
   ```bash
   mysql -u root -p < bdtask.sql
   ```
   This creates the `bdtask` database and a single `tasks` table (`id`, `title`, `description`).

2. **Configure the database connection.**
   Create a `.env` file in the project root (see `.gitignore` — it's not committed):
   ```
   DB_HOST=127.0.0.1
   DB_USER=root
   DB_PASS=
   DB_NAME=bdtask
   ```
   `config.php` loads these at request time via a small built-in `.env` parser (no Composer dependency required). If no `.env` is present, it falls back to `127.0.0.1` / `root` / no password / `bdtask`.

3. **Serve the app.**
   - Using XAMPP/MAMP: drop the project folder into `htdocs` (or your server's web root) and visit it through `http://localhost/...`.
   - Using PHP's built-in server:
     ```bash
     php -S localhost:8000
     ```
     then open `http://localhost:8000/index.php`.

4. **Open the app** — `index.php` lists all tasks, with a `+` button to add new ones and a "Modify" button per task to edit or delete it.

## Project Structure

| File | Purpose |
|---|---|
| `index.php` | Main page — queries and renders all tasks, add/edit modals |
| `action.php` | Handles form POSTs: `add`, `modi` (update), and numeric task IDs (delete) |
| `config.php` | Minimal `.env` loader; defines `DB_HOST`, `DB_USER`, `DB_PASS`, `DB_NAME` |
| `script.js` | Modal open/close logic and client-side field-length validation |
| `bdtask.sql` | Database schema (creates `bdtask` database + `tasks` table) |
| `input.css` | Tailwind CSS source file (`output.css` is generated locally) |
| `.env` | Local DB credentials (not committed) |

## Notes

- There is no authentication — all visitors share the same task list. This is intended for local/personal use, not a public multi-user deployment.
- `action.php` uses `mysqli_real_escape_string` and prepared statements to guard against SQL injection.
- Task IDs are looped through a fixed palette of five background colors, so card colors repeat every 5 tasks.
