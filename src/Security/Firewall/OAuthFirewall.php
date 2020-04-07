<?php declare(strict_types=1);

namespace Refugis\OAuthBundle\Security\Firewall;

use OAuth2\HttpFoundationBridge\Request;
use OAuth2\Response;
use OAuth2\Server;
use Refugis\OAuthBundle\Exception\OAuthAuthenticationException;
use Refugis\OAuthBundle\Security\Token\OAuthToken;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response as HttpResponse;
use Symfony\Component\HttpKernel\Event\RequestEvent;
use Symfony\Component\Security\Core\Authentication\AuthenticationManagerInterface;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Exception\AuthenticationException;

class OAuthFirewall
{
    private Server $oauthServer;
    private TokenStorageInterface $tokenStorage;
    private AuthenticationManagerInterface $authenticationManager;

    public function __construct(
        Server $oauthServer,
        TokenStorageInterface $tokenStorage,
        AuthenticationManagerInterface $authenticationManager
    ) {
        $this->oauthServer = $oauthServer;
        $this->tokenStorage = $tokenStorage;
        $this->authenticationManager = $authenticationManager;
    }

    /**
     * Gets the OAuthServer.
     *
     * @return Server
     */
    public function getOAuthServer(): Server
    {
        return $this->oauthServer;
    }

    public function __invoke(RequestEvent $event): void
    {
        $request = $event->getRequest();
        $authHeader = $request->headers->get('Authorization');
        if (null === $authHeader || ! \preg_match('/^bearer /i', $authHeader)) {
            return;
        }

        $request = Request::createFromRequest($request);

        $response = new Response();
        $response->setError(HttpResponse::HTTP_UNAUTHORIZED, 'access_denied', 'OAuth authentication required');

        $data = $this->oauthServer->getAccessTokenData($request, $response);

        if (empty($data)) {
            $event->setResponse(JsonResponse::create($response->getParameters(), $response->getStatusCode(), $response->getHttpHeaders()));

            return;
        }

        $token = new OAuthToken();
        $token->setToken($data);

        try {
            $result = $this->authenticationManager->authenticate($token);

            \assert($result instanceof TokenInterface);

            $this->tokenStorage->setToken($result);
        } catch (AuthenticationException $ex) {
            $previous = $ex->getPrevious();
            if ($previous instanceof OAuthAuthenticationException) {
                $event->setResponse($previous->getHttpResponse());
            }
        }
    }
}
