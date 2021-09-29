<?php declare(strict_types = 1);

namespace App\Model\Database;

use App\Model\Database\Entity\Author;
use App\Model\Database\Entity\Book;
use App\Model\Database\Entity\Category;
use App\Model\Database\Entity\Location;
use App\Model\Database\Entity\Magazine;
use App\Model\Database\Entity\Publisher;
use App\Model\Database\Entity\User;
use App\Model\Database\Repository\AuthorRepository;
use App\Model\Database\Repository\BookRepository;
use App\Model\Database\Repository\CategoryRepository;
use App\Model\Database\Repository\LocationRepository;
use App\Model\Database\Repository\MagazineRepository;
use App\Model\Database\Repository\PublisherRepository;
use App\Model\Database\Repository\UserRepository;

/**
 * @mixin EntityManager
 */
trait TRepositories
{
	public function getAuthorRepository(): AuthorRepository
	{
		return $this->getRepository(Author::class);
	}

	public function getUserRepository(): UserRepository
	{
		return $this->getRepository(User::class);
	}

	public function getBookRepository(): BookRepository
	{
		return $this->getRepository(Book::class);
	}

	public function getCategoryRepository(): CategoryRepository
	{
		return $this->getRepository(Category::class);
	}

	public function getMagazineRepository(): MagazineRepository
	{
		return $this->getRepository(Magazine::class);
	}

	public function getPublisherRepository(): PublisherRepository
	{
		return $this->getRepository(Publisher::class);
	}

	public function getLocationRepository(): LocationRepository
	{
		return $this->getRepository(Location::class);
	}
}
