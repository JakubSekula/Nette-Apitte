<?php declare(strict_types = 1);

namespace App\Model\Database\Repository;

use App\Model\Database\Entity\Book;

/**
 * @method Book|NULL find($id, ?int $lockMode = NULL, ?int $lockVersion = NULL)
 * @method Book|NULL findOneBy(array $criteria, array $orderBy = NULL)
 * @method Book[] findAll()
 * @method Book[] findBy(array $criteria, array $orderBy = NULL, ?int $limit = NULL, ?int $offset = NULL)
 * @extends AbstractRepository<Book>
 */
class BookRepository extends AbstractRepository
{
}
