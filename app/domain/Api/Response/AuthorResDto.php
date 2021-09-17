<?php declare(strict_types = 1);

namespace App\Domain\Api\Response;

use App\Model\Database\Entity\Author;
use DateTimeInterface;

final class AuthorResDto
{

	/** @var int */
	public $id;

	/** @var string */
	public $name;

	/** @var string */
	public $surname;

	public static function from(Author $author): self
	{
		$self = new self();
		$self->id = $author->getId();
		$self->name = $author->getName();
		$self->surname = $author->getSurname();

		return $self;
	}

}
