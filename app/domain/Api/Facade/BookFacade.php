<?php declare(strict_types = 1);

namespace App\Domain\Api\Facade;

use Apitte\Core\Exception\Api\ServerErrorException;
use App\Domain\Api\Request\CreateBookReqDto;
use App\Domain\Api\Request\CreateUserReqDto;
use App\Domain\Api\Response\AuthorResDto;
use App\Domain\Api\Response\BookResDto;
use App\Domain\Api\Response\UserResDto;
use App\Model\Database\Entity\Book;
use App\Model\Database\Entity\User;
use App\Model\Database\EntityManager;
use App\Model\Exception\Runtime\Database\EntityNotFoundException;
use App\Model\Security\Passwords;

final class BookFacade extends AbstractFacade
{

	public function __construct(EntityManager $em)
	{
		parent::__construct($em);
		$this->repository = $this->em->getBookRepository();
		$this->DtoFrom = BookResDto::class;
	}

	public function create(CreateBookReqDto $dto): Book
	{
		$book = new Book();

		$book->setName($dto->name);
		$book->setPublished($dto->published);
		$book->setISBN($dto->isbn);
		$book->setBorrowed();

		$author = $this->em->getAuthorRepository()->findOneBy(['id' => $dto->author]);
		$category = $this->em->getCategoryRepository()->findOneBy(['id' => $dto->category]);
		$publisher = $this->em->getPublisherRepository()->findOneBy(['id' => $dto->publisher]);
		$book->setAuthor($author);
		$book->setCategory($category);
		$book->setPublisher($publisher);

		$this->em->persist($book);
		$this->em->flush();

		return $book;
	}

	public function findByBookName(string $name): BookResDto
	{
		return $this->findOneBy(['name' => $name]);
	}

	public function returnByBookName(string $name): BookResDto
	{
		$book = $this->findOneByReturnBook(['name' => $name]);
		$returned = $book->getBorrowed();

		if(!$returned){
			throw ServerErrorException::create()
				->withMessage('Book has been returned');
		}

		$book->returnBook();
		$this->em->persist($book);
		$this->em->flush();

		return $this->findOneBy(['name' => $name]);
	}

	public function borrowByBookName(string $name): BookResDto
	{
		$book = $this->findOneByReturnBook(['name' => $name]);
		$borrowed = $book->getBorrowed();

		if($borrowed){
			throw ServerErrorException::create()
				->withMessage('Book is already borrowed');
		}

		$book->borrow();

		$this->em->persist($book);
		$this->em->flush();

		return $this->findOneBy(['name' => $name]);
	}

}
