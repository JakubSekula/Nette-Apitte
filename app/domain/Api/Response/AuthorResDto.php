<?php declare(strict_types = 1);

namespace App\Domain\Api\Response;

use App\Model\Database\Entity\Author;
use DateTimeInterface;

final class AuthorResDto
{

	/** @var int */
	public int $id;

	/** @var string */
	public string $name;

	/** @var string */
	public string $surname;

	public static function from(Author $author): self
	{
		$self = new self();
		$self->id = $author->getId();
		$self->name = $author->getName();
		$self->surname = $author->getSurname();

		return $self;
	}

}
