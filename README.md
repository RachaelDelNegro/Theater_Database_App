# Theater_Database_App
This is a web-based application that connects to a shared MySQL database on the UVA CS server to manage a theater production (cast, crew, events, props, costumes, etc.).

## How to run
### 1. Clone the repo
```bash
git clone https://github.com/RachaelDelNegro/Theater_Database_App
cd Theater_Database_App
```

### 2. Set up database connection
Each team member must create their own config.php file
Copy the example file: 
```bash
cp config.example.php config.php
```
Open `config.php` and replace:
```bash
$username = "your_mysql_username";
$password = "your_mysql_password";
```
Note: config.php is ignored via `.gitignore` to keep credentials private

## Database Info
Host: mysql01.cs.virginia.edu
Database: sep8vb_b

## Testing your setup
Open page in your browser
```bash
https://www.cs.virginia.edu/~[computing_id]/Theater_Database_App/db_test.php
```