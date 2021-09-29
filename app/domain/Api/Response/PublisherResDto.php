<?php declare(strict_types = 1);

namespace App\Domain\Api\Response;

use App\Model\Database\Entity\Author;
use App\Model\Database\Entity\Book;
use App\Model\Database\Entity\Category;
use App\Model\Database\Entity\Publisher;
use DateTimeInterface;

final class PublisherResDto
{

	/** @var int */
	public $id;

	/** @var string */
	public $name;

	public static function from(Publisher $publisher): self
	{
		$self = new self();
		$self->id = $publisher->getId();
		$self->name = $publisher->getName();

		return $self;
	}

}
