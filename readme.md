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
