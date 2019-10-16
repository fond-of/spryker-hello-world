<?php

declare(strict_types = 1);

namespace FondOfSpryker\Glue\HelloWorld\Plugin\ResourceRoute;

use FondOfSpryker\Glue\HelloWorld\HelloWorldConfig;
use Generated\Shared\Transfer\RestHelloWorldAttributesTransfer;
use Spryker\Glue\GlueApplicationExtension\Dependency\Plugin\ResourceRouteCollectionInterface;
use Spryker\Glue\GlueApplicationExtension\Dependency\Plugin\ResourceRoutePluginInterface;
use Spryker\Glue\Kernel\AbstractPlugin;

/**
 * @method \FondOfSpryker\Glue\CompanyUserCartsRestApi\CompanyUserCartsRestApiFactory getFactory()
 */
class HelloWorldResourceRoutePlugin extends AbstractPlugin implements ResourceRoutePluginInterface
{
    /**
     * @param \Spryker\Glue\GlueApplicationExtension\Dependency\Plugin\ResourceRouteCollectionInterface $resourceRouteCollection
     *
     * @return \Spryker\Glue\GlueApplicationExtension\Dependency\Plugin\ResourceRouteCollectionInterface
     */
    public function configure(ResourceRouteCollectionInterface $resourceRouteCollection): ResourceRouteCollectionInterface
    {
        $resourceRouteCollection
            ->addGet('get');

        return $resourceRouteCollection;
    }

    /**
     * @return string
     */
    public function getResourceType(): string
    {
        return HelloWorldConfig::RESOURCE_HELLO_WORLD;
    }

    /**
     * @return string
     */
    public function getController(): string
    {
        return HelloWorldConfig::CONTROLLER_HELLO_WORLD;
    }


    /**
     * @return string
     */
    public function getResourceAttributesClassName(): string
    {
        return RestHelloWorldAttributesTransfer::class;
    }
}
