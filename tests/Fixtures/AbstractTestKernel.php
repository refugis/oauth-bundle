<?php declare(strict_types=1);

namespace Refugis\OAuthBundle\Tests\Fixtures;

use Refugis\OAuthBundle\OAuthBundle;
use Symfony\Bundle\FrameworkBundle\FrameworkBundle;
use Symfony\Bundle\SecurityBundle\SecurityBundle;
use Symfony\Component\HttpKernel\Kernel;

abstract class AbstractTestKernel extends Kernel
{
    /**
     * {@inheritdoc}
     */
    public function registerBundles(): iterable
    {
        yield new FrameworkBundle();
        yield new SecurityBundle();
        yield new OAuthBundle();
    }

    protected function getKernelParameters(): array
    {
        return parent::getKernelParameters() + [
            'kernel.root_dir' => \dirname((new \ReflectionClass($this))->getFileName()),
        ];
    }
}
