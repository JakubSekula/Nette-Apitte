<?php declare(strict_types = 1);

namespace App\Module\V1;

use Apitte\Core\Annotation\Controller\Method;
use Apitte\Core\Annotation\Controller\OpenApi;
use Apitte\Core\Annotation\Controller\Path;
use Apitte\Core\Annotation\Controller\Tag;
use Apitte\Core\Exception\Api\ServerErrorException;
use Apitte\Core\Http\ApiRequest;
use Apitte\Core\Http\ApiResponse;
use App\Domain\Api\Facade\AuthorFacade;
use App\Domain\Api\Facade\UsersFacade;
use App\Domain\Api\Request\CreateAuthorReqDto;
use App\Domain\Api\Request\CreateUserReqDto;
use Doctrine\DBAL\Exception\DriverException;
use Nette\Http\IResponse;

/**
 * @Path("/authors")
 * @Tag("Author")
 */
class AuthorCreateController extends BaseV1Controller
{

	/** @var AuthorFacade */
	private $authorFacade;

	public function __construct(AuthorFacade $authorFacade)
	{
		$this->authorFacade = $authorFacade;
	}

	/**
	 * @OpenApi("
	 *   summary: Create new user.
	 * ")
	 * @Path("/create")
	 * @Method("POST")
	 * @Tag(name="request.dto", value="App\Domain\Api\Request\CreateAuthorReqDto")
	 */
	public function create(ApiRequest $request, ApiResponse $response): ApiResponse
	{
		/** @var CreateAuthorReqDto $dto */
		$dto = $request->getParsedBody();

		try {
			$this->authorFacade->create($dto);

			return $response->withStatus(IResponse::S201_CREATED)
				->withHeader('Content-Type', 'application/json');
		} catch (DriverException $e) {
			throw ServerErrorException::create()
				->withMessage('Cannot create user')
				->withPrevious($e);
		}
	}

}
