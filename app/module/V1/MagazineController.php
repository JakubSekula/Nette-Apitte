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
use App\Domain\Api\Facade\MagazineFacade;
use App\Domain\Api\Response\AuthorResDto;
use App\Domain\Api\Response\BookResDto;
use App\Domain\Api\Response\MagazineResDto;
use App\Domain\Api\Response\UserResDto;
use Doctrine\ORM\EntityNotFoundException;
use Nette\Http\IResponse;

/**
 * @Path("/magazines")
 * @Tag("Magazine")
 */
class MagazineController extends BaseV1Controller
{

	/** @var MagazineFacade */
	private $magazineFacade;

	public function __construct(MagazineFacade $magazineFacade)
	{
		$this->magazineFacade = $magazineFacade;
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
	 * @return MagazineResDto[]
	 */
	public function index(ApiRequest $request): array
	{
		return $this->magazineFacade->findAll(
			intval($request->getParameter('limit', 10)),
			intval($request->getParameter('offset', 0))
		);
	}

	/**
	 * @OpenApi("
	 *   summary: Get magazine by name.
	 * ")
	 * @Path("/{name}")
	 * @Method("GET")
	 * @RequestParameters({
	 *      @RequestParameter(name="name", in="path", type="string", description="Magazine name")
	 * })
	 */
	public function byName(ApiRequest $request): MagazineResDto
	{
		try {
			return $this->magazineFacade->findByMagazineName($request->getParameter('name'));
		} catch (EntityNotFoundException $e) {
			throw ClientErrorException::create()
				->withMessage('Category not found')
				->withCode(IResponse::S404_NOT_FOUND);
		}
	}

	/**
	 * @OpenApi("
	 *   summary: Boorow magazine by name.
	 * ")
	 * @Path("/borrow/{name}")
	 * @Method("GET")
	 * @RequestParameters({
	 *      @RequestParameter(name="name", in="path", type="string", description="Book name")
	 * })
	 */
	public function borrowByName(ApiRequest $request): MagazineResDto
	{
		try {
			return $this->magazineFacade->borrowByMagazineName($request->getParameter('name'));
		} catch (EntityNotFoundException $e) {
			throw ClientErrorException::create()
				->withMessage('Category not found')
				->withCode(IResponse::S404_NOT_FOUND);
		}
	}

	/**
	 * @OpenApi("
	 *   summary: Boorow magazine by name.
	 * ")
	 * @Path("/return/{name}")
	 * @Method("GET")
	 * @RequestParameters({
	 *      @RequestParameter(name="name", in="path", type="string", description="Book name")
	 * })
	 */
	public function returnBorrowedByName(ApiRequest $request): MagazineResDto
	{
		try {
			return $this->magazineFacade->returnByMagazineName($request->getParameter('name'));
		} catch (EntityNotFoundException $e) {
			throw ClientErrorException::create()
				->withMessage('Magazine already borrowed')
				->withCode(IResponse::S404_NOT_FOUND);
		}
	}

}
