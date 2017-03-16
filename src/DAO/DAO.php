<?php

namespace MyBooksApp\DAO;


use Doctrine\DBAL\Connection;

abstract class DAO
{
    /**
     * Database connection
     * @var Connection
     */
    private $db;

    /**
     * DAO constructor.
     * @param Connection $db
     */
    public function __construct(Connection $db)
    {
        $this->db = $db;
    }

    /**
     * Grants access to the database connection
     * @return Connection
     */
    protected function getDb()
    {
        return $this->db;
    }

    /**
     * Builds a domain object from a db row
     * @param array $row
     * @return mixed
     */
    protected abstract function buildDomainObject(array $row);
}
