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
 * @Entity(repositoryClass="App\Model\Database\Repository\BookRepository")
 * @ORM\Table(name="`book`")
 * @ORM\HasLifecycleCallbacks
 */
class Book extends AbstractEntity
{
	use TId;

	/** @Column(type="string") */
	private string $name;

	/** @Column(type="string") */
	private string $published;

	/** @Column(type="string") */
	private string $ISBN;

	/** @Column(type="boolean") */
	private bool $borrowed;

	/**
	 * @var Author
	 * @ManyToOne(targetEntity="Author", inversedBy="books")
	 * @JoinColumn(name="author", referencedColumnName="id")
	 */
	private Author $author;

	/**
	 * @var Publisher
	 * @ManyToOne(targetEntity="Publisher")
	 * @JoinColumn(name="publisher", referencedColumnName="id")
	 */
	private Publisher $publisher;

	/**
	 * @var Category
	 * @ManyToOne(targetEntity="Category")
	 * @JoinColumn(name="category", referencedColumnName="id")
	 */
	private Category $category;

	/**
	 * @return mixed
	 */
	public function getName(): string
	{
		return $this->name;
	}

	/**
	 * @return mixed
	 */
	public function getPublished(): string
	{
		return $this->published;
	}

	/**
	 * @return mixed
	 */
	public function getISBN(): string
	{
		return $this->ISBN;
	}

	/**
	 * @return mixed
	 */
	public function getBorrowed(): bool
	{
		return $this->borrowed;
	}

	public function setBorrowed()
	{
		$this->borrowed = false;
	}

	/**
	 * @return Author
	 */
	public function getAuthor(): Author
	{
		return $this->author;
	}

	/**
	 * @return Publisher
	 */
	public function getPublisher(): Publisher
	{
		return $this->publisher;
	}

	/**
	 * @return Category
	 */
	public function getCategory(): Category
	{
		return $this->category;
	}

	public function setName(string $name)
	{
		$this->name = $name;
	}



	public function setPublished(string $published)
	{
		$this->published = $published;
	}

	public function setISBN(string $isbn)
	{
		$this->ISBN = $isbn;
	}

	public function swapBorrowed()
	{
		if($this->borrowed == true){
			$this->borrowed = false;
		} else {
			$this->borrowed = true;
		}
	}

	/**
	 * @param Author
	 */
	public function setAuthor($author)
	{
		$this->author = $author;
	}

	/**
	 * @param Publisher
	 */
	public function setPublisher($publisher)
	{
		$this->publisher = $publisher;
	}

	/**
	 * @param Category
	 */
	public function setCategory($category)
	{
		$this->category = $category;
	}

	public function borrow()
	{
		if($this->borrowed){
			return false;
		} else {
			$this->borrowed = true;
		}
	}

	public function returnBook()
	{
		if(!$this->borrowed){
			return false;
		} else {
			$this->borrowed = false;
		}
	}
}
