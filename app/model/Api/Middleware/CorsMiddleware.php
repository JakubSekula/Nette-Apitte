<?php

namespace App\Model\Api\Middleware;

use Contributte\Middlewares\IMiddleware;
use Nette\Utils\Json;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Log\LoggerInterface;

class CorsMiddleware implements IMiddleware
{
	private const WHITELIST_ORIGINS = ['https://seznam.cz'];

	/** @var LoggerInterface */
	private $logger;

	public function __construct(LoggerInterface $logger)
	{
		$this->logger = $logger;
	}

	/**
	 * @param ServerRequestInterface $request
	 * @param ResponseInterface $response
	 * @param callable $next
	 * @return ResponseInterface
	 */
	public function __invoke(
		ServerRequestInterface $request,
		ResponseInterface $response,
		callable $next
	): ResponseInterface {
		$allowed = false;

		if(isset($request->getHeaders()["origin"])) {
			$origins = $request->getHeaders()["origin"];
			foreach($origins as $origin){
				if (in_array($origin, self::WHITELIST_ORIGINS)) {
					$this->logger->info($origin);
					$allowed = true;
				}
			}

			if($allowed){
				return $next($request, $response);
			}
		}

		return $this->denied($request, $response);
	}

	protected function denied(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface
	{
		$response->getBody()->write(Json::encode([
			'status' => 'error',
			'message' => 'Uknown request origin',
			'code' => 401,
		]));

		return $response
			->withHeader('Content-Type', 'application/json')
			->withStatus(401);
	}
}
