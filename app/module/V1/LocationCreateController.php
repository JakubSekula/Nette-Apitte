<?php declare(strict_types = 1);

namespace App\Module\V1;

use Apitte\Core\Annotation\Controller\Method;
use Apitte\Core\Annotation\Controller\OpenApi;
use Apitte\Core\Annotation\Controller\Path;
use Apitte\Core\Annotation\Controller\RequestParameter;
use Apitte\Core\Annotation\Controller\RequestParameters;
use Apitte\Core\Annotation\Controller\Tag;
use Apitte\Core\Exception\Api\ServerErrorException;
use Apitte\Core\Http\ApiRequest;
use Apitte\Core\Http\ApiResponse;
use App\Domain\Api\Facade\AuthorFacade;
use App\Domain\Api\Facade\BookFacade;
use App\Domain\Api\Facade\LocationFacade;
use App\Domain\Api\Request\CreateBookReqDto;
use App\Domain\Api\Request\CreateLocationReqDto;
use App\Domain\Api\Request\CreateUserReqDto;
use App\Domain\Api\Response\AuthorResDto;
use App\Domain\Api\Response\BookResDto;
use App\Domain\Api\Response\UserResDto;
use Doctrine\DBAL\Exception\DriverException;
use Nette\Http\IResponse;

/**
 * @Path("/locations")
 * @Tag("Books")
 */
class LocationCreateController extends BaseV1Controller
{

	/** @var LocationFacade */
	private $locationFacade;

	public function __construct(LocationFacade $locationFacade)
	{
		$this->locationFacade = $locationFacade;
	}

	/**
	 * @OpenApi("
	 *   summary: Create new library.
	 * ")
	 * @Path("/create")
	 * @Method("POST")
	 * @Tag(name="request.dto", value="App\Domain\Api\Request\CreateLocationReqDto")
	 */
	public function create(ApiRequest $request, ApiResponse $response): ApiResponse
	{
		/** @var CreateLocationReqDto $dto */
		$dto = $request->getParsedBody();

		try {
			$this->locationFacade->create($dto);

			return $response->withStatus(IResponse::S201_CREATED)
				->withHeader('Content-Type', 'application/json');
		} catch (DriverException $e) {
			throw ServerErrorException::create()
				->withMessage('Cannot create user')
				->withPrevious($e);
		}
	}

}
