<?php

/**
 * @see       https://github.com/laminas/laminas-servicemanager-di for the canonical source repository
 * @copyright https://github.com/laminas/laminas-servicemanager-di/blob/master/COPYRIGHT.md
 * @license   https://github.com/laminas/laminas-servicemanager-di/blob/master/LICENSE.md New BSD License
 */

namespace Laminas\ServiceManager\Di;

use Interop\Container\ContainerInterface;
use Laminas\ServiceManager\FactoryInterface;
use Laminas\ServiceManager\ServiceLocatorInterface;
use Laminas\ServiceManager\ServiceManager;

class DiAbstractServiceFactoryFactory implements FactoryInterface
{
    /**
     * Class responsible for instantiating a DiAbstractServiceFactory
     *
     * @param ContainerInterface $container
     * @param string $name
     * @param null|array $options
     * @return DiAbstractServiceFactory
     */
    public function __invoke(ContainerInterface $container, $name, array $options = null)
    {
        $factory = new DiAbstractServiceFactory($container->get('Di'), DiAbstractServiceFactory::USE_SL_BEFORE_DI);

        if ($container instanceof ServiceManager) {
            $container->addAbstractFactory($factory, false);
        }

        return $factory;
    }

    /**
     * Create and return DiAbstractServiceFactory instance
     *
     * For use with laminas-servicemanager v2; proxies to __invoke().
     *
     * @param ServiceLocatorInterface $container
     * @return DiAbstractServiceFactory
     */
    public function createService(ServiceLocatorInterface $container)
    {
        return $this($container, DiAbstractServiceFactory::class);
    }
}
