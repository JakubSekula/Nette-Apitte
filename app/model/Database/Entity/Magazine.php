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
class Magazine extends AbstractEntity
{
	use TId;

	/** @Column(type="string") */
	private $name;

	/**
	 * @var Publisher
	 * @ManyToOne(targetEntity="Publisher")
	 * @JoinColumn(name="publisher", referencedColumnName="id")
	 */
	private $publisher;

	/** @Column(type="boolean") */
	private $borrowed;

	public function setName(string $name){
		$this->name = $name;
	}

	public function getName(){
		return $this->name;
	}

	/**
	 * @param Publisher
	 */
	public function setPublisher($publisher){
		$this->publisher = $publisher;
	}

	public function getPublisher(){
		return $this->publisher;
	}

	public function swapBorrowed(){
		if($this->borrowed == true){
			$this->borrowed = false;
		} else {
			$this->borrowed = true;
		}
	}
}
