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
use App\Domain\Api\Facade\UsersFacade;
use App\Domain\Api\Response\UserResDto;
use App\Model\Exception\Runtime\Database\EntityNotFoundException;
use App\Module\V1\BaseV1Controller;
use Nette\Http\IResponse;

/**
 * @Path("/users")
 * @Tag("Users")
 */
class UsersController extends BaseV1Controller
{

	/** @var UsersFacade */
	private $usersFacade;

	public function __construct(UsersFacade $usersFacade)
	{
		$this->usersFacade = $usersFacade;
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
	 * @return UserResDto[]
	 */
	public function index(ApiRequest $request): array
	{
		return $this->usersFacade->findAll(
			intval($request->getParameter('limit', 10)),
			intval($request->getParameter('offset', 0))
		);
	}

	/**
	 * @OpenApi("
	 *   summary: Get user by name.
	 * ")
	 * @Path("/{name}/{surname}")
	 * @Method("GET")
	 * @RequestParameters({
	 *      @RequestParameter(name="name", in="path", type="string", description="User name"),
	 * 		@RequestParameter(name="surname", in="path", type="string", description="User surname")
	 * })
	 */
	public function byName(ApiRequest $request): UserResDto
	{
		try {
			return $this->usersFacade->findByUserName($request->getParameter('name'), $request->getParameter('surname'));
		} catch (EntityNotFoundException $e) {
			throw ClientErrorException::create()
				->withMessage('User not found')
				->withCode(IResponse::S404_NOT_FOUND);
		}
	}

}
