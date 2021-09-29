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
use Faker\Guesser\Name;
use Nette\Utils\Random;
use Doctrine\ORM\Mapping\JoinColumn;

/**
 * @Entity(repositoryClass="App\Model\Database\Repository\LocationRepository")
 * @ORM\Table(name="`location`")
 * @ORM\HasLifecycleCallbacks
 */
class Location extends AbstractEntity
{
	use TId;

	/** @Column(type="string") */
	private $library;

	/** @var Name
	 * @Column(type="string")
	 */
	private $name;

	/** @var integer
	 * @Column(type="integer")
	 */
	private $pegi;

	/**
	 * @param string $library
	 */
	public function setLibrary(string $library){
		$this->library = $library;
	}

	/**
	 * @return mixed
	 */
	public function getLibrary(){
		return $this->library;
	}

	/**
	 * @param string $library
	 */
	public function setName(string $name){
		$this->name = $name;
	}

	/**
	 * @return mixed
	 */
	public function getName(){
		return $this->name;
	}

	/**
	 * @param integer $pegi
	 */
	public function setPegi(int $pegi){
		$this->pegi = $pegi;
	}

	/**
	 * @return mixed
	 */
	public function getPegi(){
		return $this->pegi;
	}
}
