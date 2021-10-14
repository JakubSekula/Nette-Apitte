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

final class AuthorFacade extends AbstractFacade
{

	public function __construct(EntityManager $em)
	{
		parent::__construct($em);
		$this->repository = $this->em->getAuthorRepository();
		$this->DtoFrom = AuthorResDto::class;
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
