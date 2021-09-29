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
use App\Domain\Api\Facade\MagazineFacade;
use App\Domain\Api\Request\CreateBookReqDto;
use App\Domain\Api\Request\CreateMagazineReqDto;
use App\Domain\Api\Request\CreateUserReqDto;
use App\Domain\Api\Response\AuthorResDto;
use App\Domain\Api\Response\BookResDto;
use App\Domain\Api\Response\UserResDto;
use Doctrine\DBAL\Exception\DriverException;
use Nette\Http\IResponse;

/**
 * @Path("/magazines")
 * @Tag("Magazine")
 */
class MagazineCreateController extends BaseV1Controller
{

	/** @var MagazineFacade */
	private $magazineFacade;

	public function __construct(MagazineFacade $magazineFacade)
	{
		$this->magazineFacade = $magazineFacade;
	}

	/**
	 * @OpenApi("
	 *   summary: Create new book.
	 * ")
	 * @Path("/create")
	 * @Method("POST")
	 * @Tag(name="request.dto", value="App\Domain\Api\Request\CreateMagazineReqDto")
	 */
	public function create(ApiRequest $request, ApiResponse $response): ApiResponse
	{
		/** @var CreateMagazineReqDto $dto */
		$dto = $request->getParsedBody();

		try {
			$this->magazineFacade->create($dto);

			return $response->withStatus(IResponse::S201_CREATED)
				->withHeader('Content-Type', 'application/json');
		} catch (DriverException $e) {
			throw ServerErrorException::create()
				->withMessage('Cannot create user')
				->withPrevious($e);
		}
	}

}
