<?php
/**
 * @link      http://github.com/zendframework/zend-mvc-i18n for the canonical source repository
 * @copyright Copyright (c) 2005-2016 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Zend\Mvc\I18n\Router;

use Interop\Container\ContainerInterface;
use Zend\I18n\Translator\TranslatorInterface;
use Zend\ServiceManager\DelegatorFactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class HttpRouterDelegatorFactory implements DelegatorFactoryInterface
{
    /**
     * Decorate the HttpRouter factory.
     *
     * If the HttpRouter factory returns a TranslatorAwareTreeRouteStack, we
     * should inject it with a translator.
     *
     * If the MvcTranslator service is available, that translator is used.
     * If the TranslatorInterface service is available, that translator is used.
     *
     * Otherwise, we disable translation in the instance before returning it.
     *
     * @param ContainerInterface $container
     * @param string $name
     * @param callable $callback
     * @param null|arry $options
     * @return \Zend\Router\RouteStackInterface|TranslatorAwareTreeRouteStack
     */
    public function __invoke(ContainerInterface $container, $name, callable $callback, array $options = null)
    {
        $router = $callback();

        if (! $router instanceof TranslatorAwareTreeRouteStack) {
            return $router;
        }

        if ($container->has('MvcTranslator')) {
            $router->setTranslator($container->get('MvcTranslator'));
            return $router;
        }

        if ($container->has(TranslatorInterface::class)) {
            $router->setTranslator($container->get(TranslatorInterface::class));
            return $router;
        }

        $router->setTranslatorEnabled(false);

        return $router;
    }

    /**
     * zend-servicemanager v2 compabibility
     *
     * @param ServiceLocatorInterface $container
     * @param string $name
     * @param string $requestedName
     * @param callable $callback
     * @return \Zend\Router\RouteStackInterface|TranslatorAwareTreeRouteStack
     */
    public function createDelegatorWithName(ServiceLocatorInterface $container, $name, $requestedName, $callback)
    {
        return $this($container, $requestedName, $callback);
    }
}
