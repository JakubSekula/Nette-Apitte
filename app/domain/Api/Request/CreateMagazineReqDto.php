<?php declare(strict_types = 1);

namespace App\Domain\Api\Request;

use App\Model\Database\Entity\Author;
use App\Model\Database\Entity\Publisher;
use Symfony\Component\Validator\Constraints as Assert;

final class CreateMagazineReqDto
{

	/**
	 * @var string
	 * @Assert\NotBlank
	 */
	public $name;

	/**
	 * @var Publisher
	 * @Assert\NotBlank
	 */
	public $publisher;

}
