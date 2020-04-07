<?php declare(strict_types=1);

namespace Refugis\OAuthBundle\DependencyInjection\CompilerPass;

use Refugis\OAuthBundle\Command\CreateClientCommand;
use Refugis\OAuthBundle\Security\Factory\OAuthFactory;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;

class CreateClientCommandPass implements CompilerPassInterface
{
    /**
     * {@inheritdoc}
     */
    public function process(ContainerBuilder $container): void
    {
        $userProviders = $container->getParameter(OAuthFactory::USER_PROVIDERS_PARAMETER_NAME);
        if (empty($userProviders)) {
            return;
        }

        $commandDefinition = $container->getDefinition(CreateClientCommand::class);
        foreach ($userProviders as $firewall => $userProvider) {
            $commandDefinition->addMethodCall('addUserProvider', [$firewall, new Reference($userProvider)]);
        }
    }
}
