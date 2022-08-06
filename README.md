# Generate PDO connection string

This is a php package to generate pdo connection string based on database, name and optionally a port.

```php
use use Danilocgsilva\PdoStringBuilder\Builder;

$stringBuilder = new Builder();
$stringBuilder
    ->setDbDns("a-database-dns-or-ip")
    ->setDbName("your-db-name");

$pdoString = $stringBuilder->getPdoString();
```
Then uses `$pdoString` as the first argument to your pdo object.

Optionally, use the method `setDbPort` to set the database port if other than 3306.
