# 
You'll need the following installed on your system before you can start working on Iceberg.

- [PHP 8.X](https://www.php.net/downloads) or above
- [Composer](https://getcomposer.org)
- [Docker](https://docs.docker.com/desktop/)
- [Docker Compose](https://docs.docker.com/compose/install/)

### Starting and running application
- Run this command: `composer install`
- Start the stack with `./vendor/bin/sail up`

### Static Analysis
This will run static analysis to make sure code is PSR compliant

```
composer larastan
```

