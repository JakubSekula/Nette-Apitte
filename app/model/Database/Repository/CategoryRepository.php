<?php declare(strict_types = 1);

namespace App\Model\Database\Repository;

use App\Model\Database\Entity\Category;

/**
 * @method Category|NULL find($id, ?int $lockMode = NULL, ?int $lockVersion = NULL)
 * @method Category|NULL findOneBy(array $criteria, array $orderBy = NULL)
 * @method Category[] findAll()
 * @method Category[] findBy(array $criteria, array $orderBy = NULL, ?int $limit = NULL, ?int $offset = NULL)
 * @extends AbstractRepository<Category>
 */
class CategoryRepository extends AbstractRepository
{
}
