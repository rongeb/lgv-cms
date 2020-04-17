<?php
namespace Searchws\Controller;

use Interop\Container\ContainerInterface;
use Interop\Container\Exception\ContainerException;
use Searchws\Controller\SearchwsController;
use Zend\Mvc\I18n\Translator;
use Zend\ServiceManager\Exception\ServiceNotCreatedException;
use Zend\ServiceManager\Exception\ServiceNotFoundException;
use Zend\ServiceManager\Factory\FactoryInterface;
use Application\Factory\CacheDataListener;

/**
 * Class SearchwsControllerFactory
 * @package Searchws\Controller
 */
class SearchwsControllerFactory implements FactoryInterface {

    /**
     * Create an object
     *
     * @param  ContainerInterface $container
     * @param  string $requestedName
     * @param  null|array $options
     * @return object
     * @throws ServiceNotFoundException if unable to resolve the service.
     * @throws ServiceNotCreatedException if an exception is raised when
     *     creating a service.
     * @throws ContainerException if any other error occurs
     */
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        return new SearchwsController($container->get(CacheDataListener::class), $container->get(Translator::class));
    }
}