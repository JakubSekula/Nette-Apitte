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
use App\Model\Database\Repository\AuthorRepository;

/**
 * @Entity(repositoryClass="App\Model\Database\Repository\AuthorRepository")
 * @ORM\Table(name="`author`")
 * @ORM\HasLifecycleCallbacks
 */
class Author extends AbstractEntity
{
	use TId;

	/** @Column(type="string") */
	private string $name;

	/** @Column(type="string") */
	private string $surname;

	/**
	 * @var Author
	 * @OneToMany(targetEntity="Book", mappedBy="author")
	 */
	private $books;

	public function getName(): string
	{
		return $this->name;
	}

	public function setName(string $name): Author
	{
		$this->name = $name;
		return $this;
	}

	public function getSurname(): string
	{
		return $this->surname;
	}

	public function setSurname(string $surname)
	{
		$this->surname = $surname;
	}

}
