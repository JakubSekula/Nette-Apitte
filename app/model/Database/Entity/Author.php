<?php declare(strict_types = 1);

namespace App\Model\Database\Entity;

use App\Model\Database\Entity\Attributes\TCreatedAt;
use App\Model\Database\Entity\Attributes\TId;
use App\Model\Database\Entity\Attributes\TUpdatedAt;
use App\Model\Exception\Logic\InvalidArgumentException;
use App\Model\Utils\DateTime;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\Id;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\OneToMany;
use Doctrine\ORM\Mapping\GeneratedValue;
use Nette\Utils\Random;

/**
 * @Entity()
 */
class Author extends AbstractEntity
{
	use TId;

	/** @Column(type="string") */
	private $name;

	/** @Column(type="string") */
	private $surname;

	/**
	 * @var Author
	 * @OneToMany(targetEntity="Book", mappedBy="author")
	 */
	private $books;

	public function getName(){
		return $this->name;
	}

	public function setName(string $name){
		$this->name = $name;
		return $this;
	}

	public function getSurname(){
		return $this->surname;
	}

	public function setSurname(string $surname){
		$this->surname = $surname;
	}

}
