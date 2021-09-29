<?php declare(strict_types = 1);

namespace App\Domain\Api\Facade;

use App\Domain\Api\Request\CreateAuthorReqDto;
use App\Domain\Api\Request\CreateUserReqDto;
use App\Domain\Api\Response\AuthorResDto;
use App\Domain\Api\Response\UserResDto;
use App\Model\Database\Entity\Author;
use App\Model\Database\Entity\User;
use App\Model\Database\EntityManager;
use App\Model\Exception\Runtime\Database\EntityNotFoundException;
use App\Model\Security\Passwords;

final class AuthorFacade
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
	 * @return AuthorResDto[]
	 */
	public function findBy(array $criteria = [], array $orderBy = ['id' => 'ASC'], int $limit = 10, int $offset = 0): array
	{
		$entities = $this->em->getAuthorRepository()->findBy($criteria, $orderBy, $limit, $offset);
		$result = [];

		foreach ($entities as $entity) {
			$result[] = AuthorResDto::from($entity);
		}

		return $result;
	}

	/**
	 * @return AuthorResDto[]
	 */
	public function findAll(int $limit = 10, int $offset = 0): array
	{
		return $this->findBy([], ['id' => 'ASC'], $limit, $offset);
	}

	/**
	 * @param mixed[] $criteria
	 * @param string[] $orderBy
	 */
	public function findOneBy(array $criteria, ?array $orderBy = null):AuthorResDto
	{
		$entity = $this->em->getAuthorRepository()->findOneBy($criteria, $orderBy);

		if (!$entity) {
			throw new EntityNotFoundException();
		}

		return AuthorResDto::from($entity);
	}

	public function findOne(int $id): AuthorResDto
	{
		return $this->findOneBy(['id' => $id]);
	}

	public function create(CreateAuthorReqDto $dto): Author
	{
		$author = new Author();
		$author->setName($dto->name);
		$author->setSurname($dto->surname);

		$this->em->persist($author);
		$this->em->flush($author);

		return $author;
	}

}
