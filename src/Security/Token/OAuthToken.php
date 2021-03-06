<?php declare(strict_types=1);

namespace Refugis\OAuthBundle\Security\Token;

use Symfony\Component\Security\Core\Authentication\Token\AbstractToken;

class OAuthToken extends AbstractToken
{
    private array $token;

    /**
     * @return array
     */
    public function getToken(): array
    {
        return $this->token;
    }

    /**
     * @param array $token
     *
     * @return $this
     */
    public function setToken(array $token): self
    {
        $this->token = $token;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getCredentials(): array
    {
        return $this->token;
    }
}
