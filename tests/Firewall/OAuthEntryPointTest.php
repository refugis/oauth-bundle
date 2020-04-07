<?php declare(strict_types=1);

namespace Refugis\OAuthBundle\Tests\Firewall;

use PHPUnit\Framework\TestCase;
use Prophecy\Prophecy\ObjectProphecy;
use Refugis\OAuthBundle\Security\Firewall\OAuthEntryPoint;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class OAuthEntryPointTest extends TestCase
{
    /**
     * @var OAuthEntryPoint|ObjectProphecy
     */
    private object $entryPoint;

    /**
     * {@inheritdoc}
     */
    protected function setUp(): void
    {
        $this->entryPoint = new OAuthEntryPoint();
    }

    public function testStartShouldReturnUnauthorizedJsonResponse(): void
    {
        $data = [
            'error' => 'access_denied',
            'error_description' => 'OAuth authentication required',
        ];

        $request = $this->prophesize(Request::class);

        $response = $this->entryPoint->start($request->reveal());

        self::assertEquals($data, \json_decode($response->getContent(), true));
        self::assertEquals('application/json', $response->headers->get('Content-Type'));
        self::assertEquals(Response::HTTP_UNAUTHORIZED, $response->getStatusCode());
    }
}
