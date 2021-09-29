<?php declare(strict_types = 1);

namespace App\Domain\Api\Response;

use App\Model\Database\Entity\Author;
use App\Model\Database\Entity\Book;
use App\Model\Database\Entity\Category;
use App\Model\Database\Entity\Publisher;
use DateTimeInterface;

final class BookResDto
{

	/** @var int */
	public $id;

	/** @var Author */
	public $author;

	/** @var string */
	public $published;

	/** @var Publisher */
	public $publisher;

	/** @var Category */
	public $category;

	/** @var string */
	public $name;

	/** @var string */
	public $isbn;

	/** @var boolean */
	public $borrowed;

	public static function from(Book $book): self
	{
		$self = new self();
		$self->id = $book->getId();
		$self->author = $book->getAuthor();
		$self->published = $book->getPublished();
		$self->publisher = $book->getPublisher();
		$self->category = $book->getCategory();
		$self->name = $book->getName();
		$self->isbn = $book->getISBN();
		$self->borrowed = $book->getBorrowed();

		return $self;
	}

}
