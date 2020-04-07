<?php declare(strict_types=1);

namespace App\Tests\Encryption;

use PHPUnit\Framework\TestCase;
use Refugis\OAuthBundle\Encryption\SignerFactory;
use Refugis\OAuthBundle\Enum\SignatureAlgorithm;

class SignerFactoryTest extends TestCase
{
    public function dataProviderForFactoryAlgorithms(): iterable
    {
        foreach (SignatureAlgorithm::values() as $algorithm) {
            yield [$algorithm];
        }
    }

    /**
     * @dataProvider dataProviderForFactoryAlgorithms
     */
    public function testFactoryWorksForAlgorithms(SignatureAlgorithm $algorithm): void
    {
        self::assertNotNull(SignerFactory::factory($algorithm));
    }
}
