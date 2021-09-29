<?php declare(strict_types = 1);

namespace App\Domain\Api\Facade;

use App\Domain\Api\Request\CreateCategoryReqDto;
use App\Domain\Api\Request\CreateUserReqDto;
use App\Domain\Api\Response\CategoryResDto;
use App\Domain\Api\Response\UserResDto;
use App\Model\Database\Entity\Category;
use App\Model\Database\Entity\User;
use App\Model\Database\EntityManager;
use App\Model\Exception\Runtime\Database\EntityNotFoundException;
use App\Model\Security\Passwords;

final class CategoryFacade
{

	/** @var EntityManager */
	private $em;

	public function __construct(EntityManager $em)
	{
		$this->em = $em;
	}

	/**
	 * @param mixed[] $criteria
	 * @param string[] $orderBy
	 * @return CategoryResDto[]
	 */
	public function findBy(array $criteria = [], array $orderBy = ['id' => 'ASC'], int $limit = 10, int $offset = 0): array
	{
		$entities = $this->em->getCategoryRepository()->findBy($criteria, $orderBy, $limit, $offset);
		$result = [];

		foreach ($entities as $entity) {
			$result[] = CategoryResDto::from($entity);
		}

		return $result;
	}

	/**
	 * @return CategoryResDto[]
	 */
	public function findAll(int $limit = 10, int $offset = 0): array
	{
		return $this->findBy([], ['id' => 'ASC'], $limit, $offset);
	}

	public function findByCategoryName(string $name): CategoryResDto
	{
		return $this->findOneBy(['name' => $name]);
	}

	/**
	 * @param mixed[] $criteria
	 * @param string[] $orderBy
	 */
	public function findOneBy(array $criteria, ?array $orderBy = null): CategoryResDto
	{
		$entity = $this->em->getCategoryRepository()->findOneBy($criteria, $orderBy);

		if (!$entity) {
			throw new EntityNotFoundException();
		}

		return CategoryResDto::from($entity);
	}

	public function findOne(int $id): CategoryResDto
	{
		return $this->findOneBy(['id' => $id]);
	}

	public function create(CreateCategoryReqDto $dto): Category
	{
		$category = new Category();
		$category->setName($dto->name);

		$this->em->persist($category);
		$this->em->flush($category);

		return $category;
	}

}
