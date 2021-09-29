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
use App\Domain\Api\Facade\PublisherFacade;
use App\Domain\Api\Response\AuthorResDto;
use App\Domain\Api\Response\BookResDto;
use App\Domain\Api\Response\MagazineResDto;
use App\Domain\Api\Response\PublisherResDto;
use App\Domain\Api\Response\UserResDto;
use Doctrine\ORM\EntityNotFoundException;
use Nette\Http\IResponse;

/**
 * @Path("/publishers")
 * @Tag("Publishers")
 */
class PublisherController extends BaseV1Controller
{

	/** @var PublisherFacade */
	private $publisherFacade;

	public function __construct(PublisherFacade $publisherFacade)
	{
		$this->publisherFacade = $publisherFacade;
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
	 * @return PublisherResDto[]
	 */
	public function index(ApiRequest $request): array
	{
		return $this->publisherFacade->findAll(
			intval($request->getParameter('limit', 10)),
			intval($request->getParameter('offset', 0))
		);
	}

	/**
	 * @OpenApi("
	 *   summary: Get publisher by name.
	 * ")
	 * @Path("/{name}")
	 * @Method("GET")
	 * @RequestParameters({
	 *      @RequestParameter(name="name", in="path", type="string", description="Publisher name")
	 * })
	 */
	public function byName(ApiRequest $request): PublisherResDto
	{
		try {
			return $this->publisherFacade->findByPublisherName($request->getParameter('name'));
		} catch (EntityNotFoundException $e) {
			throw ClientErrorException::create()
				->withMessage('Category not found')
				->withCode(IResponse::S404_NOT_FOUND);
		}
	}

}
