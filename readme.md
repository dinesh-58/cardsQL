## Requirements  
- php (Windows users may require some additional steps. See [here](https://www.php.net/manual/en/sqlite3.installation.php))
- php-sqlite

## Usage   
Find your `php.ini` file. Located in `/etc/php/` on Linux.
Uncomment the line `extension=pdo_sqlite`.

``` sh
git clone https://github.com/dinesh-58/cardsQL.git
cd cardsQL
php -S localhost:8000
```
Then, open `localhost:8000` in your browser.

## Screenshots
### Add/Home Interface
![](./screenshots/add.png)
### Review/practice cards Interface
![](./screenshots/review-before.png)
![](./screenshots/review-after.png)
### Edit cards Interface
![](./screenshots/edit-before.png)
![](./screenshots/edit-after.png)
