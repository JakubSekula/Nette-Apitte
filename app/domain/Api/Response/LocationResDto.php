<?php declare(strict_types = 1);

namespace App\Domain\Api\Response;

use App\Model\Database\Entity\Author;
use App\Model\Database\Entity\Book;
use App\Model\Database\Entity\Category;
use App\Model\Database\Entity\Location;
use App\Model\Database\Entity\Publisher;
use DateTimeInterface;

final class LocationResDto
{

	/** @var int */
	public int $id;

	/** @var string */
	public string $name;

	/** @var string */
	public string $library;

	/** @var integer */
	public int $pegi;

	public static function from(Location $location): self
	{
		$self = new self();
		$self->id = $location->getId();
		$self->name = $location->getName();
		$self->library = $location->getLibrary();
		$self->pegi = $location->getPegi();
		return $self;
	}

}
