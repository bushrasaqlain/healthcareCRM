# Healthcare Project

## Requirements

* PHP 8.2+
* Composer
* MySQL
* XAMPP (or Apache/Nginx)

## Installation

Clone the repository:

```bash
git clone <repository-url>
cd healthcare
```

Install PHP dependencies:

```bash
composer install
```

Create environment file:

```bash
cp env .env
```

Update the database settings in `.env`:

```env
database.default.hostname = localhost
database.default.database = healthcare
database.default.username = root
database.default.password =
database.default.DBDriver = MySQLi
database.default.port = 3306
```

## Running the Project

Using CodeIgniter development server:

```bash
php spark serve
```

Open:

```text
http://localhost:8080
```

Or using XAMPP:

Place the project inside:

```text
C:\xampp\htdocs\healthcare
```

Open:

```text
http://localhost/healthcare/public
```

## Database

Create a database named:

```text
healthcare
```

Run migrations if available:

```bash
php spark migrate
```

## Git Workflow

Pull latest changes:

```bash
git pull
```

Install dependencies after pulling:

```bash
composer install
```

## Important

Do not commit:

* .env
* vendor/
* node_modules/
* writable/logs/
* writable/cache/
* writable/session/
