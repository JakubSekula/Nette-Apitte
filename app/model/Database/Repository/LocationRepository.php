<?php declare(strict_types = 1);

namespace App\Model\Database\Repository;

use App\Model\Database\Entity\Book;
use App\Model\Database\Entity\Location;

/**
 * @method Location|NULL find($id, ?int $lockMode = NULL, ?int $lockVersion = NULL)
 * @method Location|NULL findOneBy(array $criteria, array $orderBy = NULL)
 * @method Location[] findAll()
 * @method Location[] findBy(array $criteria, array $orderBy = NULL, ?int $limit = NULL, ?int $offset = NULL)
 * @extends AbstractRepository<Location>
 */
class LocationRepository extends AbstractRepository
{
}
