<?php declare(strict_types = 1);

namespace App\Domain\Api\Facade;

use Apitte\Core\Exception\Api\ServerErrorException;
use App\Domain\Api\Request\CreateMagazineReqDto;
use App\Domain\Api\Request\CreateUserReqDto;
use App\Domain\Api\Response\BookResDto;
use App\Domain\Api\Response\MagazineResDto;
use App\Domain\Api\Response\UserResDto;
use App\Model\Database\Entity\Book;
use App\Model\Database\Entity\Magazine;
use App\Model\Database\Entity\User;
use App\Model\Database\EntityManager;
use App\Model\Exception\Runtime\Database\EntityNotFoundException;
use App\Model\Security\Passwords;

final class MagazineFacade
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
	 * @return MagazineResDto[]
	 */
	public function findBy(array $criteria = [], array $orderBy = ['id' => 'ASC'], int $limit = 10, int $offset = 0): array
	{
		$entities = $this->em->getMagazineRepository()->findBy($criteria, $orderBy, $limit, $offset);
		$result = [];

		foreach ($entities as $entity) {
			$result[] = MagazineResDto::from($entity);
		}

		return $result;
	}

	/**
	 * @return MagazineResDto[]
	 */
	public function findAll(int $limit = 10, int $offset = 0): array
	{
		return $this->findBy([], ['id' => 'ASC'], $limit, $offset);
	}

	/**
	 * @param mixed[] $criteria
	 * @param string[] $orderBy
	 */
	public function findOneBy(array $criteria, ?array $orderBy = null): MagazineResDto
	{
		$entity = $this->em->getMagazineRepository()->findOneBy($criteria, $orderBy);

		if (!$entity) {
			throw new EntityNotFoundException();
		}

		return MagazineResDto::from($entity);
	}

	public function findOne(int $id): MagazineResDto
	{
		return $this->findOneBy(['id' => $id]);
	}

	public function create(CreateMagazineReqDto $dto): Magazine
	{
		$magazine = new Magazine();

		$magazine->setName($dto->name);
		$magazine->setPublisher($this->em->getPublisherRepository()->findOneBy(['id' => $dto->publisher]));
		$magazine->setBorrowed();

		$this->em->persist($magazine);
		$this->em->flush($magazine);

		return $magazine;
	}

	/**
	 * @param mixed[] $criteria
	 * @param string[] $orderBy
	 */
	public function findOneByReturnMagazine(array $criteria, ?array $orderBy = null): Magazine
	{
		$entity = $this->em->getMagazineRepository()->findOneBy($criteria, $orderBy);

		if (!$entity) {
			throw new EntityNotFoundException();
		}

		return $entity;
	}

	public function findByMagazineName(string $name): MagazineResDto
	{
		return $this->findOneBy(['name' => $name]);
	}

	public function returnByMagazineName(string $name): MagazineResDto
	{
		$magazine = $this->findOneByReturnMagazine(['name' => $name]);
		$returned = $magazine->getBorrowed();

		if(!$returned){
			throw ServerErrorException::create()
				->withMessage('Magazine has been returned');
		}

		$magazine->returnMagazine();

		$this->em->persist($magazine);
		$this->em->flush();

		return $this->findOneBy(['name' => $name]);
	}

	public function borrowByMagazineName(string $name): MagazineResDto
	{
		$magazine = $this->findOneByReturnMagazine(['name' => $name]);
		$borrowed = $magazine->getBorrowed();

		if($borrowed){
			throw ServerErrorException::create()
				->withMessage('Magazine is already borrowed');
		}

		$magazine->borrow();

		$this->em->persist($magazine);
		$this->em->flush();

		return $this->findOneBy(['name' => $name]);
	}

}
