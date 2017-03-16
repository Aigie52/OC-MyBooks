<?php

namespace MyBooksApp\DAO;


use MyBooksApp\Domain\Book;

class BookDAO extends DAO
{
    /**
     * @var AuthorDAO
     */
    private $authorDAO;

    /**
     * @param AuthorDAO $authorDAO
     */
    public function setAuthorDAO (AuthorDAO $authorDAO)
    {
        $this->authorDAO = $authorDAO;
    }

    /**
     * Return a list of books, sorted by date (most recent first)
     * @return array
     */
    public function findAll()
    {
        $sql = "select book_id, book_title, book_summary from book order by book_id desc";
        $result = $this->getDb()->fetchAll($sql);

        $books = array();
        foreach ($result as $row) {
            $bookId = $row['book_id'];
            $books[$bookId] = $this->buildDomainObject($row);
        }

        return $books;
    }

    public function find($id)
    {
        $sql = "select * from book where id=?";
        $row = $this->getDb()->fetchAssoc($sql, array($id));

        if ($row)
            return $this->buildDomainObject($row);
        else
            throw new \Exception("No book matching id " . $id);
    }

    /**
     * Builds a domain object from a db row
     * @param array $row
     * @return Book
     */
    protected function buildDomainObject(array $row)
    {
        $book = new Book();
        $book->setId($row['book_id']);
        $book->setSummary($row['book_summary']);
        $book->setTitle($row['book_title']);

        if (array_key_exists('book_isbn', $row)) $book->setIsbn($row['book_isbn']);
        if (array_key_exists('auth_id', $row)) {
            $authorId = $row['auth_id'];
            $author = $this->authorDAO->find($authorId);
            $book->setAuthor($author);
        }

        return $book;
    }
}
