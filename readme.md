<!---
Note to self: versions 1.0.0 and before represents state of project before being used for 6th sem project
--->
## Requirements
- php (Windows users may require some additional steps. See [here](https://www.php.net/manual/en/sqlite3.installation.php))
- sqlite
- php-sqlite

## Usage
- Install the above requirements.
- Find your `php.ini` file & uncomment the line `extension=pdo_sqlite`. (Located in `/etc/php/` on Linux)

``` sh
git clone https://github.com/dinesh-58/cardsQL.git
cd cardsQL
php -S localhost:8000
sqlite3 cardsql.db < commands.sql  # create required db file & tables
```
Then, open `localhost:8000` in your browser.

> [!NOTE] 
> If you use a separate port number, URL, you may want to update `BASE_URL` in `bootstrap.php`

## Screenshots
### Add/Home Interface
![](./screenshots/add.png)
### Review/practice cards Interface
![](./screenshots/review-before.png)
![](./screenshots/review-after.png)
### Edit cards Interface
![](./screenshots/edit-before.png)
![](./screenshots/edit-after.png)

## Notes for developers
- Follow [Usage](#Usage) to setup the project
- You may also want to enable php error display. Set these in your `php.ini` file.
  ```ini
  display_errors = On
  display_startup_errors = On
  ```
- **Create a separate branch for features & open PRs against main**
- To connect to the sqlite db w/ php, alwyas use the given function in `utils`
- Use [PDO](https://www.php.net/manual/en/book.pdo.php) for db-related operations
- When database schema changes, make sure you pull the latest changes, then delete `cardsql.db` and run `sqlite3 cardsql.db < commands.sql`
