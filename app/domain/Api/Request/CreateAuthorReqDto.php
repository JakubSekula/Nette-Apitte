<?php declare(strict_types = 1);

namespace App\Domain\Api\Request;

use Symfony\Component\Validator\Constraints as Assert;

final class CreateAuthorReqDto
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
	public $surname;

}
