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
use App\Domain\Api\Facade\CategoryFacade;
use App\Domain\Api\Facade\UsersFacade;
use App\Domain\Api\Response\CategoryResDto;
use App\Domain\Api\Response\UserResDto;
use Doctrine\ORM\EntityNotFoundException;
use Nette\Http\IResponse;

/**
 * @Path("/category")
 * @Tag("Category")
 */
class CategoryController extends BaseV1Controller
{

	/** @var CategoryFacade */
	private $categoryFacade;

	public function __construct(CategoryFacade $categoryFacade)
	{
		$this->categoryFacade = $categoryFacade;
	}

	/**
	 * @OpenApi("
	 *   summary: List users.
	 * ")
	 * @Path("/")
	 * @Method("GET")
	 * @RequestParameters({
	 * 		@RequestParameter(name="limit", type="int", in="query", required=false, description="Data limit"),
	 * 		@RequestParameter(name="offset", type="int", in="query", required=false, description="Data offset")
	 * })
	 * @return CategoryResDto[]
	 */
	public function index(ApiRequest $request): array
	{
		return $this->categoryFacade->findAll(
			intval($request->getParameter('limit', 10)),
			intval($request->getParameter('offset', 0))
		);
	}

	/**
	 * @OpenApi("
	 *   summary: Get category by name.
	 * ")
	 * @Path("/{name}")
	 * @Method("GET")
	 * @RequestParameters({
	 *      @RequestParameter(name="name", in="path", type="string", description="Category name")
	 * })
	 */
	public function byName(ApiRequest $request): CategoryResDto
	{
		try {
			return $this->categoryFacade->findByCategoryName($request->getParameter('name'));
		} catch (EntityNotFoundException $e) {
			throw ClientErrorException::create()
				->withMessage('Category not found')
				->withCode(IResponse::S404_NOT_FOUND);
		}
	}

}
