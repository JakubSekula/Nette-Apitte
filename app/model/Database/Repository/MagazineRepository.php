<?php declare(strict_types = 1);

namespace App\Model\Database\Repository;

use App\Model\Database\Entity\Magazine;

/**
 * @method Magazine|NULL find($id, ?int $lockMode = NULL, ?int $lockVersion = NULL)
 * @method Magazine|NULL findOneBy(array $criteria, array $orderBy = NULL)
 * @method Magazine[] findAll()
 * @method Magazine[] findBy(array $criteria, array $orderBy = NULL, ?int $limit = NULL, ?int $offset = NULL)
 * @extends AbstractRepository<Magazine>
 */
class MagazineRepository extends AbstractRepository
{
}
