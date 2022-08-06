<?php

declare(strict_types=1);

use PHPUnit\Framework\TestCase;
use Danilocgsilva\PdoStringBuilder\Builder;
use Exception;

class BuilderTest extends TestCase
{
    private Builder $builder;
    
    public function setUp(): void
    {
        $this->builder = new Builder();
    }
    
    public function testGetPdoString()
    {
        $dbHost = "127.0.1.13";
        $dbName = "politicians_querier";

        $expected = 'mysql:host=127.0.1.13;dbname=politicians_querier';

        $this->builder
            ->setDbDns($dbHost)
            ->setDbName($dbName);

        $this->assertSame($expected, $this->builder->getPdoString());
    }

    public function testGetPdoStringWithDnsName()
    {
        $dbHost = "the-database-dns";
        $dbName = "politicians_querier";

        $expected = 'mysql:host=the-database-dns;dbname=politicians_querier';

        $this->builder
            ->setDbDns($dbHost)
            ->setDbName($dbName);

        $this->assertSame($expected, $this->builder->getPdoString());
    }

    public function testGetPdoStringExceptionForgetSetValues()
    {
        $this->expectException(Exception::class);

        $this->builder->getPdoString();
    }

    public function testGetPdoStringExceptionForgetSetSingleValue()
    {
        $this->expectException(Exception::class);
        $this->builder->setDbDns("some-dns");
        $this->builder->getPdoString();
    }

    public function testGetPdoStringWithPord()
    {
        $dbHost = "the-database-dns";
        $dbName = "politicians_querier";
        $dbPort = 3308;

        $this->builder
            ->setDbDns($dbHost)
            ->setDbName($dbName)
            ->setDbPort($dbPort);

        $expected = 'mysql:host=the-database-dns;dbname=politicians_querier;port=3308';

        $this->assertSame($expected, $this->builder->getPdoString());
    }
}
