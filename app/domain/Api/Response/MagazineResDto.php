<?php declare(strict_types = 1);

namespace App\Domain\Api\Response;

use App\Model\Database\Entity\Author;
use App\Model\Database\Entity\Book;
use App\Model\Database\Entity\Category;
use App\Model\Database\Entity\Magazine;
use App\Model\Database\Entity\Publisher;
use DateTimeInterface;

final class MagazineResDto
{

	/** @var int */
	public $id;

	/** @var Publisher */
	public $publisher;

	/** @var string */
	public $name;

	/** @var boolean */
	public $borrowed;

	public static function from(Magazine $magazine): self
	{
		$self = new self();
		$self->id = $magazine->getId();
		$self->publisher = $magazine->getPublisher();
		$self->name = $magazine->getName();
		$self->borrowed = $magazine->getBorrowed();

		return $self;
	}

}
