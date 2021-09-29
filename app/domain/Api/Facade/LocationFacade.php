<?php declare(strict_types = 1);

namespace App\Domain\Api\Facade;

use App\Domain\Api\Request\CreateLocationReqDto;
use App\Domain\Api\Response\CategoryResDto;
use App\Domain\Api\Response\LocationResDto;
use App\Model\Database\Entity\Location;
use App\Model\Database\EntityManager;
use App\Model\Exception\Runtime\Database\EntityNotFoundException;

final class LocationFacade
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
	 * @return LocationResDto[]
	 */
	public function findBy(array $criteria = [], array $orderBy = ['id' => 'ASC'], int $limit = 10, int $offset = 0): array
	{
		$entities = $this->em->getLocationRepository()->findBy($criteria, $orderBy, $limit, $offset);
		$result = [];

		foreach ($entities as $entity) {
			$result[] = LocationResDto::from($entity);
		}

		return $result;
	}

	/**
	 * @return LocationResDto[]
	 */
	public function findAll(int $limit = 10, int $offset = 0): array
	{
		return $this->findBy([], ['id' => 'ASC'], $limit, $offset);
	}

	/**
	 * @param mixed[] $criteria
	 * @param string[] $orderBy
	 */
	public function findOneBy(array $criteria, ?array $orderBy = null): LocationResDto
	{
		$entity = $this->em->getLocationRepository()->findOneBy($criteria, $orderBy);

		if (!$entity) {
			throw new EntityNotFoundException();
		}

		return LocationResDto::from($entity);
	}

	public function findOne(int $id): LocationResDto
	{
		return $this->findOneBy(['id' => $id]);
	}

	public function create(CreateLocationReqDto $dto): Location
	{
		$location = new Location();

		$location->setName($dto->name);
		$location->setLibrary($dto->library);
		$location->setPegi((int) $dto->pegi);

		$this->em->persist($location);
		$this->em->flush();

		return $location;
	}

	public function findByLocationName(string $library): LocationResDto
	{
		return $this->findOneBy(['library' => $library]);
	}

}
