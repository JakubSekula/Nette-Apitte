<?php declare(strict_types = 1);

namespace App\Model\Database\Repository;

use App\Model\Database\Entity\Author;

/**
 * @method Author|NULL find($id, ?int $lockMode = NULL, ?int $lockVersion = NULL)
 * @method Author|NULL findOneBy(array $criteria, array $orderBy = NULL)
 * @method Author[] findAll()
 * @method Author[] findBy(array $criteria, array $orderBy = NULL, ?int $limit = NULL, ?int $offset = NULL)
 * @extends AbstractRepository<Author>
 */
class AuthorRepository extends AbstractRepository
{
}
