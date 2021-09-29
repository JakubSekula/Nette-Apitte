<?php declare(strict_types = 1);

namespace App\Domain\Api\Response;

use App\Model\Database\Entity\Author;
use App\Model\Database\Entity\Book;
use App\Model\Database\Entity\Category;
use DateTimeInterface;

final class CategoryResDto
{

	/** @var int */
	public $id;

	/** @var string */
	public $name;

	public static function from(Category $category): self
	{
		$self = new self();
		$self->id = $category->getId();
		$self->name = $category->getName();

		return $self;
	}

}
