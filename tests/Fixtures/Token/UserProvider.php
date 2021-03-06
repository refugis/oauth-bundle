<?php declare(strict_types=1);

namespace Refugis\OAuthBundle\Tests\Fixtures\Token;

use Refugis\OAuthBundle\Security\Provider\UserProviderInterface;
use Refugis\OAuthBundle\Security\User\OAuthClientInterface;
use Symfony\Component\Security\Core\User\UserInterface;

class UserProvider implements UserProviderInterface
{
    /**
     * {@inheritdoc}
     */
    public function provideUser(array $tokenData): ?UserInterface
    {
        return null;
    }

    /**
     * {@inheritdoc}
     */
    public function provideClient(array $tokenData): ?OAuthClientInterface
    {
        return new OAuthClient();
    }

    /**
     * {@inheritdoc}
     */
    public function createClient(string $name, array $redirectUris, array $grantTypes): OAuthClientInterface
    {
        return new OAuthClient();
    }
}
