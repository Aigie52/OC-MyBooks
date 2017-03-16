<?php

namespace MyBooksApp\DAO;


use MyBooksApp\Domain\Author;

class AuthorDAO extends DAO
{
    /**
     * @param $id
     * @return Author
     * @throws \Exception
     */
    public function find($id)
    {
        $sql = "select * from author where auth_id=?";
        $row = $this->getDb()->fetchAssoc($sql, array($id));

        if ($row)
            return $this->buildDomainObject($row);
        else
            throw new \Exception("No author matching id " . $id);
    }


    /**
     * Builds a domain object from a db row
     * @param array $row
     * @return Author
     */
    protected function buildDomainObject(array $row)
    {
        $author = new Author();
        $author->setId($row['auth_id']);
        $author->setFirstName($row['auth_first_name']);
        $author->setLastName($row['auth_last_name']);

        return $author;
    }
}
