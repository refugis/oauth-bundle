<?php declare(strict_types=1);

namespace Refugis\OAuthBundle\DependencyInjection;

use Symfony\Component\DependencyInjection\ContainerInterface;

class Reference
{
    private string $id;
    private int $invalidBehavior;

    public function __construct(string $id, int $invalidBehavior = ContainerInterface::EXCEPTION_ON_INVALID_REFERENCE)
    {
        $this->id = $id;
        $this->invalidBehavior = $invalidBehavior;
    }

    public function __toString(): string
    {
        return $this->id;
    }

    /**
     * Returns the behavior to be used when the service does not exist.
     *
     * @return int
     */
    public function getInvalidBehavior(): int
    {
        return $this->invalidBehavior;
    }
}
