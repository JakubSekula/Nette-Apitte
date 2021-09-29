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
use App\Domain\Api\Facade\LocationFacade;
use App\Domain\Api\Response\AuthorResDto;
use App\Domain\Api\Response\BookResDto;
use App\Domain\Api\Response\CategoryResDto;
use App\Domain\Api\Response\LocationResDto;
use App\Domain\Api\Response\UserResDto;
use Doctrine\ORM\EntityNotFoundException;
use Nette\Http\IResponse;

/**
 * @Path("/locations")
 * @Tag("Locations")
 */
class LocationController extends BaseV1Controller
{

	/** @var LocationFacade */
	private $locationFacade;

	public function __construct(LocationFacade $locationFacade)
	{
		$this->locationFacade = $locationFacade;
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
	 * @return LocationResDto[]
	 */
	public function index(ApiRequest $request): array
	{
		return $this->locationFacade->findAll(
			intval($request->getParameter('limit', 10)),
			intval($request->getParameter('offset', 0))
		);
	}

	/**
	 * @OpenApi("
	 *   summary: Get library by name.
	 * ")
	 * @Path("/{library}")
	 * @Method("GET")
	 * @RequestParameters({
	 *      @RequestParameter(name="library", in="path", type="string", description="Library name")
	 * })
	 */
	public function byName(ApiRequest $request): LocationResDto
	{
		try {
			return $this->locationFacade->findByLocationName($request->getParameter('library'));
		} catch (EntityNotFoundException $e) {
			throw ClientErrorException::create()
				->withMessage('Library not found')
				->withCode(IResponse::S404_NOT_FOUND);
		}
	}

}
