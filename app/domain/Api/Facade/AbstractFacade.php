<?php

namespace App\Domain\Api\Facade;

use App\Domain\Api\Request\CreateAuthorReqDto;
use App\Domain\Api\Response\AuthorResDto;
use App\Model\Database\Entity\Author;
use App\Model\Database\EntityManager;
use Doctrine\ORM\Mapping\ClassMetadata;
use App\Model\Exception\Runtime\Database\EntityNotFoundException;

abstract class AbstractFacade
{
	/** @var EntityManager */
	protected EntityManager $em;

	protected $repository;

	protected $DtoFrom;

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
		$entities = $this->repository->findBy($criteria, $orderBy, $limit, $offset);
		$result = [];

		foreach ($entities as $entity) {
			$result[] = $this->DtoFrom::from($entity);
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
		$entity = $this->repository->findOneBy($criteria, $orderBy);

		if (!$entity) {
			throw new EntityNotFoundException();
		}

		return $this->DtoFrom::from($entity);
	}

	public function findOne(int $id): AuthorResDto
	{
		return $this->findOneBy(['id' => $id]);
	}

}
