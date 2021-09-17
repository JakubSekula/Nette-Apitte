<?php declare(strict_types = 1);

namespace App\Module\V1;

use Apitte\Core\Annotation\Controller\Method;
use Apitte\Core\Annotation\Controller\OpenApi;
use Apitte\Core\Annotation\Controller\Path;
use Apitte\Core\Annotation\Controller\RequestParameter;
use Apitte\Core\Annotation\Controller\RequestParameters;
use Apitte\Core\Annotation\Controller\Tag;
use Apitte\Core\Http\ApiRequest;
use App\Domain\Api\Facade\AuthorFacade;
use App\Domain\Api\Response\AuthorResDto;
use App\Domain\Api\Response\UserResDto;

/**
 * @Path("/authors")
 * @Tag("Authors")
 */
class AuthorController extends BaseV1Controller
{

	/** @var AuthorFacade */
	private $authorFacade;

	public function __construct(AuthorFacade $authorFacade)
	{
		$this->authorFacade = $authorFacade;
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
	 * @return AuthorResDto[]
	 */
	public function index(ApiRequest $request): array
	{
		return $this->authorFacade->findAll(
			intval($request->getParameter('limit', 10)),
			intval($request->getParameter('offset', 0))
		);
	}

}
