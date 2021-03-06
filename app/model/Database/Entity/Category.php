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
 * @Entity(repositoryClass="App\Model\Database\Repository\CategoryRepository")
 * @ORM\Table(name="`category`")
 * @ORM\HasLifecycleCallbacks
 */
class Category extends AbstractEntity
{
	use TId;

	/** @Column(type="string") */
	private $name;

	/**
	 * @param string $name
	 */
	public function setName(string $name){
		$this->name = $name;
	}

	public function getName(){
		return $this->name;
	}
}
