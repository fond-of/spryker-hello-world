<?php

declare(strict_types = 1);

namespace FondOfSpryker\Glue\HelloWorld;

use FondOfSpryker\Glue\HelloWorld\Processor\HelloWorldReader;
use FondOfSpryker\Glue\HelloWorld\Processor\HelloWorldReaderInterface;
use FondOfSpryker\Glue\HelloWorld\Processor\Validation\RestApiError;
use FondOfSpryker\Glue\HelloWorld\Processor\Validation\RestApiErrorInterface;
use Spryker\Client\Customer\CustomerClientInterface;
use Spryker\Client\GlossaryStorage\GlossaryStorageClientInterface;
use Spryker\Glue\GlueApplication\Rest\JsonApi\RestResourceBuilderInterface;
use Spryker\Glue\Kernel\AbstractFactory;
use Spryker\Glue\Kernel\Plugin\Pimple;

class HelloWorldFactory extends AbstractFactory
{
    /**
     * @return \FondOfSpryker\Glue\HelloWorld\Processor\HelloWorldReaderInterface
     */
    public function createHelloWorldReader(): HelloWorldReaderInterface
    {
        return new HelloWorldReader(
            $this->getResourceBuilder(),
            $this->getCustomerClient(),
            $this->createRestApiError(),
            $this->getGlossaryStorageClient()
        );
    }

    /**
     * @throws
     *
     * @return \Spryker\Client\Customer\CustomerClientInterface
     */
    protected function getCustomerClient(): CustomerClientInterface
    {
        return $this->getProvidedDependency(HelloWorldDependencyProvider::CLIENT_CUSTOMER);
    }

    /**
     * @throws
     *
     * @return \Spryker\Client\GlossaryStorage\GlossaryStorageClientInterface
     */
    protected function getGlossaryStorageClient(): GlossaryStorageClientInterface
    {
        return $this->getProvidedDependency(HelloWorldDependencyProvider::CLIENT_GLOSSARY_STORAGE);
    }

    /**
     * @return \FondOfSpryker\Glue\HelloWorld\Processor\Validation\RestApiErrorInterface
     */
    protected function createRestApiError(): RestApiErrorInterface
    {
        return new RestApiError();
    }

    /**
     * @return mixed|\Spryker\Glue\GlueApplication\Rest\JsonApi\RestResourceBuilderInterface
     */
    public function getResourceBuilder(): RestResourceBuilderInterface
    {
        return (new Pimple())->getApplication()['resource_builder'];
    }
}
