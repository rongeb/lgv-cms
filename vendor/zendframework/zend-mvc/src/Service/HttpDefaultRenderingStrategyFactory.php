<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/zf2 for the canonical source repository
 * @copyright Copyright (c) 2005-2015 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Zend\Mvc\Service;

use Interop\Container\ContainerInterface;
use Zend\Mvc\View\Http\DefaultRenderingStrategy;
use Zend\ServiceManager\Factory\FactoryInterface;
use Zend\View\View;

class HttpDefaultRenderingStrategyFactory implements FactoryInterface
{
    use HttpViewManagerConfigTrait;

    /**
     * @param  ContainerInterface $container
     * @param  string $name
     * @param  null|array $options
     * @return DefaultRenderingStrategy
     */
    public function __invoke(ContainerInterface $container, $name, array $options = null)
    {
        $strategy = new DefaultRenderingStrategy($container->get(View::class));
        $config   = $this->getConfig($container);

        $this->injectLayoutTemplate($strategy, $config);

        return $strategy;
    }

    /**
     * Inject layout template.
     *
     * Uses layout template from configuration; if none available, defaults to "layout/layout".
     *
     * @param DefaultRenderingStrategy $strategy
     * @param array $config
     */
    private function injectLayoutTemplate(DefaultRenderingStrategy $strategy, array $config)
    {
        $layout = isset($config['layout']) ? $config['layout'] : 'layout/layout';
        $strategy->setLayoutTemplate($layout);
    }
}
