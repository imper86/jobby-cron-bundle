<?php
/**
 * Author: Adrian Szuszkiewicz <me@imper.info>
 * Github: https://github.com/imper86
 * Date: 07.10.2019
 * Time: 10:49
 */

namespace Imper86\JobbyBundle\DependencyInjection;


use Imper86\JobbyBundle\Command\ListCommand;
use Imper86\JobbyBundle\Factory\JobbyFactoryInterface;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader\XmlFileLoader;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;

class Imper86JobbyExtension extends Extension
{
    public function load(array $configs, ContainerBuilder $container)
    {
        $loader = new XmlFileLoader($container, new FileLocator(__DIR__ . '/../Resources/config'));
        $loader->load('services.xml');

        $configuration = $this->getConfiguration($configs, $container);
        $config = $this->processConfiguration($configuration, $configs);

        $servicesWithConfigArgument = [
            ListCommand::class,
            JobbyFactoryInterface::class,
        ];

        foreach ($servicesWithConfigArgument as $className) {
            $container->getDefinition($className)->setArgument(0, $config);
        }
    }

}
