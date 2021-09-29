<?php declare(strict_types = 1);

namespace App\Module\V1;

use Apitte\Core\Annotation\Controller\Method;
use Apitte\Core\Annotation\Controller\OpenApi;
use Apitte\Core\Annotation\Controller\Path;
use Apitte\Core\Annotation\Controller\RequestParameter;
use Apitte\Core\Annotation\Controller\RequestParameters;
use Apitte\Core\Annotation\Controller\Tag;
use Apitte\Core\Exception\Api\ClientErrorException;
use Apitte\Core\Http\ApiRequest;
use App\Domain\Api\Facade\AuthorFacade;
use App\Domain\Api\Facade\BookFacade;
use App\Domain\Api\Response\AuthorResDto;
use App\Domain\Api\Response\BookResDto;
use App\Domain\Api\Response\CategoryResDto;
use App\Domain\Api\Response\UserResDto;
use Doctrine\ORM\EntityNotFoundException;
use Nette\Http\IResponse;

/**
 * @Path("/books")
 * @Tag("Books")
 */
class BookController extends BaseV1Controller
{

	/** @var BookFacade */
	private $bookFacade;

	public function __construct(BookFacade $bookFacade)
	{
		$this->bookFacade = $bookFacade;
	}

	/**
	 * @OpenApi("
	 *   summary: List authors.
	 * ")
	 * @Path("/")
	 * @Method("GET")
	 * @RequestParameters({
	 * 		@RequestParameter(name="limit", type="int", in="query", required=false, description="Data limit"),
	 * 		@RequestParameter(name="offset", type="int", in="query", required=false, description="Data offset")
	 * })
	 * @return BookResDto[]
	 */
	public function index(ApiRequest $request): array
	{
		return $this->bookFacade->findAll(
			intval($request->getParameter('limit', 10)),
			intval($request->getParameter('offset', 0))
		);
	}

	/**
	 * @OpenApi("
	 *   summary: Get book by name.
	 * ")
	 * @Path("/{name}")
	 * @Method("GET")
	 * @RequestParameters({
	 *      @RequestParameter(name="name", in="path", type="string", description="Book name")
	 * })
	 */
	public function byName(ApiRequest $request): BookResDto
	{
		try {
			return $this->bookFacade->findByBookName($request->getParameter('name'));
		} catch (EntityNotFoundException $e) {
			throw ClientErrorException::create()
				->withMessage('Category not found')
				->withCode(IResponse::S404_NOT_FOUND);
		}
	}

	/**
	 * @OpenApi("
	 *   summary: Boorow book by name.
	 * ")
	 * @Path("/borrow/{name}")
	 * @Method("GET")
	 * @RequestParameters({
	 *      @RequestParameter(name="name", in="path", type="string", description="Book name")
	 * })
	 */
	public function borrowByName(ApiRequest $request): BookResDto
	{
		try {
			return $this->bookFacade->borrowByBookName($request->getParameter('name'));
		} catch (EntityNotFoundException $e) {
			throw ClientErrorException::create()
				->withMessage('Book already borrowed')
				->withCode(IResponse::S400_BAD_REQUEST);
		}
	}

	/**
	 * @OpenApi("
	 *   summary: Boorow book by name.
	 * ")
	 * @Path("/return/{name}")
	 * @Method("GET")
	 * @RequestParameters({
	 *      @RequestParameter(name="name", in="path", type="string", description="Book name")
	 * })
	 */
	public function returnBorrowedByName(ApiRequest $request): BookResDto
	{
		try {
			return $this->bookFacade->returnByBookName($request->getParameter('name'));
		} catch (EntityNotFoundException $e) {
			throw ClientErrorException::create()
				->withMessage('Category not found')
				->withCode(IResponse::S404_NOT_FOUND);
		}
	}

}
