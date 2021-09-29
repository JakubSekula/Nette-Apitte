<?php declare(strict_types = 1);

namespace App\Domain\Api\Request;

use App\Model\Database\Entity\Author;
use Symfony\Component\Validator\Constraints as Assert;

final class CreatePublisherReqDto
{

	/**
	 * @var string
	 * @Assert\NotBlank
	 */
	public $name;

}
