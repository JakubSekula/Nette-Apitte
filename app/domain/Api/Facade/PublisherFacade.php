<?php declare(strict_types = 1);

namespace App\Domain\Api\Facade;

use App\Domain\Api\Request\CreatePublisherReqDto;
use App\Domain\Api\Request\CreateUserReqDto;
use App\Domain\Api\Response\BookResDto;
use App\Domain\Api\Response\PublisherResDto;
use App\Domain\Api\Response\UserResDto;
use App\Model\Database\Entity\Publisher;
use App\Model\Database\Entity\User;
use App\Model\Database\EntityManager;
use App\Model\Exception\Runtime\Database\EntityNotFoundException;
use App\Model\Security\Passwords;

final class PublisherFacade
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
	 * @return PublisherResDto[]
	 */
	public function findBy(array $criteria = [], array $orderBy = ['id' => 'ASC'], int $limit = 10, int $offset = 0): array
	{
		$entities = $this->em->getPublisherRepository()->findBy($criteria, $orderBy, $limit, $offset);
		$result = [];

		foreach ($entities as $entity) {
			$result[] = PublisherResDto::from($entity);
		}

		return $result;
	}

	/**
	 * @return PublisherResDto[]
	 */
	public function findAll(int $limit = 10, int $offset = 0): array
	{
		return $this->findBy([], ['id' => 'ASC'], $limit, $offset);
	}

	/**
	 * @param mixed[] $criteria
	 * @param string[] $orderBy
	 */
	public function findOneBy(array $criteria, ?array $orderBy = null): PublisherResDto
	{
		$entity = $this->em->getPublisherRepository()->findOneBy($criteria, $orderBy);

		if (!$entity) {
			throw new EntityNotFoundException();
		}

		return PublisherResDto::from($entity);
	}

	public function findOne(int $id): PublisherResDto
	{
		return $this->findOneBy(['id' => $id]);
	}

	public function create(CreatePublisherReqDto $dto): Publisher
	{
		$publisher = new Publisher();
		$publisher->setName($dto->name);

		$this->em->persist($publisher);
		$this->em->flush($publisher);

		return $publisher;
	}

    public function findByPublisherName(string $name): PublisherResDto
    {
		return $this->findOneBy(['name' => $name]);
    }

}
