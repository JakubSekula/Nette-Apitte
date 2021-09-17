<?php declare(strict_types = 1);

namespace App\Model\Database\Entity;

use App\Model\Database\Entity\Attributes\TCreatedAt;
use App\Model\Database\Entity\Attributes\TId;
use App\Model\Database\Entity\Attributes\TUpdatedAt;
use App\Model\Exception\Logic\InvalidArgumentException;
use App\Model\Utils\DateTime;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\Id;
use Doctrine\ORM\Mapping\ManyToOne;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\GeneratedValue;
use Nette\Utils\Random;
use Doctrine\ORM\Mapping\JoinColumn;

/**
 * @Entity()
 */
class Book extends AbstractEntity
{
	use TId;

	/** @Column(type="string") */
	private $name;

	/** @Column(type="string") */
	private $published;

	/** @Column(type="string") */
	private $ISBN;

	/** @Column(type="boolean") */
	private $borrowed;

	/**
	 * @var Author
	 * @ManyToOne(targetEntity="Author", inversedBy="books")
	 * @JoinColumn(name="author", referencedColumnName="id")
	 */
	private $author;

	/**
	 * @var Publisher
	 * @ManyToOne(targetEntity="Publisher")
	 * @JoinColumn(name="publisher", referencedColumnName="id")
	 */
	private $publisher;

	/**
	 * @var Category
	 * @ManyToOne(targetEntity="Category")
	 * @JoinColumn(name="category", referencedColumnName="id")
	 */
	private $category;

	/**
	 * @return mixed
	 */
	public function getName(){
		return $this->name;
	}

	/**
	 * @return mixed
	 */
	public function getPublished(){
		return $this->published;
	}

	/**
	 * @return mixed
	 */
	public function getISBN(){
		return $this->ISBN;
	}

	/**
	 * @return mixed
	 */
	public function getBorrowed(){
		return $this->borrowed;
	}

	/**
	 * @return Author
	 */
	public function getAuthor(){
		return $this->author;
	}

	/**
	 * @return Publisher
	 */
	public function getPublisher(){
		return $this->publisher;
	}

	/**
	 * @return Category
	 */
	public function getCategory(){
		return $this->category;
	}

	public function setName(string $name){
		$this->name = $name;
	}

	public function setPublished(string $published){
		$this->published = $published;
	}

	public function setISBN(string $isbn){
		$this->isbn = $isbn;
	}

	public function swapBorrowed(){
		if($this->borrowed == true){
			$this->borrowed = false;
		} else {
			$this->borrowed = true;
		}
	}

	/**
	 * @param Author
	 */
	public function setAuthor($author){
		$this->author = $author;
	}

	/**
	 * @param Publisher
	 */
	public function setPublisher($publisher){
		$this->publisher = $publisher;
	}

	/**
	 * @param Category
	 */
	public function setCategory(string $category){
		$this->category = $category;
	}
}
