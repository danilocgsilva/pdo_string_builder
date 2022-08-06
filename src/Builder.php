<?php

declare(strict_types=1);

namespace Danilocgsilva\PdoStringBuilder;

use Exception;
use ReflectionProperty;

class Builder
{
    private string $dbDns;
    private string $dbName;
    private int $dbPort;
    private array $errorsMessages = [];

    public function setDbDns(string $dns): self
    {
        $this->dbDns = $dns;
        return $this;
    }

    public function setDbName(string $name): self
    {
        $this->dbName = $name;
        return $this;
    }

    public function setDbPort(int $portNumber): self
    {
        $this->dbPort = $portNumber;
        return $this;
    }

    public function getPdoString(): string
    {
        $this->checkErrors();
        $baseString = "mysql:host=%s;dbname=%s";

        $firstString = sprintf($baseString, $this->dbDns, $this->dbName);

        $dbPortCheck = new ReflectionProperty($this, 'dbPort');

        if (!$dbPortCheck->isInitialized($this)) {
            return $firstString;
        }

        return $firstString . ";port=" . $this->dbPort;
    }

    private function checkErrors(): void
    {
        $dbDnsCheck = new ReflectionProperty($this, 'dbDns');
        $dbNameCheck = new ReflectionProperty($this, 'dbName');
        
        if (!$dbDnsCheck->isInitialized($this)) {
            $this->errorsMessages[] = " Please, set the database host with setDbDns() method.";
        }

        if (!$dbNameCheck->isInitialized($this)) {
            $this->errorsMessages[] = " Please, set the database name with setDbName() method.";
        }

        if (count($this->errorsMessages) > 0) {
            $message = "This class have missing data." . implode("", $this->errorsMessages);

            throw new Exception($message);
        }
    }
}
