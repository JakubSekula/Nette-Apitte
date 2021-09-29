<?php declare(strict_types = 1);

namespace App\Model\Database\Repository;

use App\Model\Database\Entity\Book;
use App\Model\Database\Entity\Publisher;

/**
 * @method Publisher|NULL find($id, ?int $lockMode = NULL, ?int $lockVersion = NULL)
 * @method Publisher|NULL findOneBy(array $criteria, array $orderBy = NULL)
 * @method Publisher[] findAll()
 * @method Publisher[] findBy(array $criteria, array $orderBy = NULL, ?int $limit = NULL, ?int $offset = NULL)
 * @extends AbstractRepository<Publisher>
 */
class PublisherRepository extends AbstractRepository
{
}
