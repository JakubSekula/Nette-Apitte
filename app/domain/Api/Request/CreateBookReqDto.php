<?php declare(strict_types = 1);

namespace App\Domain\Api\Request;

use App\Model\Database\Entity\Author;
use Symfony\Component\Validator\Constraints as Assert;

final class CreateBookReqDto
{

	/**
	 * @var string
	 * @Assert\NotBlank
	 */
	public $name;

	/**
	 * @var string
	 * @Assert\NotBlank
	 */
	public $published;

	/**
	 * @var string
	 * @Assert\NotBlank
	 */
	public $isbn;

	/**
	 * @var integer
	 * @Assert\NotBlank
	 */
	public $author;

	/**
	 * @var integer
	 * @Assert\NotBlank
	 */
	public $publisher;

	/**
	 * @var integer
	 * @Assert\NotBlank
	 */
	public $category;

}
