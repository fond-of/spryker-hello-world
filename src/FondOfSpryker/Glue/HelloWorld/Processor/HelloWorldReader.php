<?php

declare(strict_types = 1);

namespace FondOfSpryker\Glue\HelloWorld\Processor;

use FondOfSpryker\Glue\HelloWorld\HelloWorldConfig;
use FondOfSpryker\Glue\HelloWorld\Processor\Validation\RestApiErrorInterface;
use Generated\Shared\Transfer\GlossaryTransfer;
use Spryker\Client\Customer\CustomerClientInterface;
use Spryker\Client\GlossaryStorage\GlossaryStorageClientInterface;
use Spryker\Glue\GlueApplication\Rest\JsonApi\RestResourceBuilderInterface;
use Spryker\Glue\GlueApplication\Rest\JsonApi\RestResponseInterface;
use Spryker\Glue\GlueApplication\Rest\Request\Data\RestRequestInterface;
use Spryker\Shared\Kernel\Store;

/**
 * @method \FondOfSpryker\Glue\HelloWorld\HelloWorldFactory getFactory()
 */
class HelloWorldReader implements HelloWorldReaderInterface
{
    /**
     * @var \Spryker\Client\Customer\CustomerClientInterface
     */
    protected $customerClient;

    /**
     * @var \FondOfSpryker\Glue\InvoicesRestApi\Processor\Validation\RestApiErrorInterface
     */
    protected $apiError;

    /**
     * @var \Spryker\Glue\GlueApplication\Rest\JsonApi\RestResourceBuilderInterface
     */
    protected $restResourceBuilder;

    /**
     * @var \Spryker\Zed\Glossary\Business\GlossaryFacadeInterface
     */
    protected $glossaryStorageClient;

    /**
     * @var \ArchitectureSniffer\Transfer\TransferInterface
     */
    protected $glossaryClient;

    /**
     * @param \Spryker\Glue\GlueApplication\Rest\JsonApi\RestResourceBuilderInterface $restResourceBuilder
     * @param \Spryker\Client\Customer\CustomerClientInterface $customerClient
     * @param \FondOfSpryker\Glue\HelloWorld\Processor\Validation\RestApiErrorInterface $apiError
     * @param \Spryker\Client\GlossaryStorage\GlossaryStorageClientInterface $glossaryStorageClient
     */
    public function __construct(
        RestResourceBuilderInterface $restResourceBuilder,
        CustomerClientInterface $customerClient,
        RestApiErrorInterface $apiError,
        GlossaryStorageClientInterface $glossaryStorageClient
    ) {
        $this->restResourceBuilder = $restResourceBuilder;
        $this->customerClient = $customerClient;
        $this->apiError = $apiError;
        $this->glossaryStorageClient = $glossaryStorageClient;
    }

    /**
     * @param \Spryker\Glue\GlueApplication\Rest\Request\Data\RestRequestInterface $restRequest
     *
     * @throws
     *
     * @return \Spryker\Glue\GlueApplication\Rest\JsonApi\RestResponseInterface
     */
    public function findGlossary(RestRequestInterface $restRequest): RestResponseInterface
    {
        $localeName = Store::getInstance()->getCurrentLocale();

        $keyTranslation = $restRequest->getResource()->getId();

        $translation = $this->glossaryStorageClient->translate($keyTranslation, $localeName);

        if ($translation === $keyTranslation) {
            return $this->apiError->addTranslationNotFoundError($this->restResourceBuilder->createRestResponse());
        }

        $glossaryTransfer = (new GlossaryTransfer())
            ->setKey($keyTranslation)
            ->setLocale($localeName)
            ->setValue($translation);

        return $this->createTranslationRestResponse($glossaryTransfer);
    }

    /**
     * @param \Generated\Shared\Transfer\GlossaryTransfer $glossaryTransfer
     *
     * @return \Spryker\Glue\GlueApplication\Rest\JsonApi\RestResponseInterface
     */
    protected function createTranslationRestResponse(GlossaryTransfer $glossaryTransfer): RestResponseInterface
    {
        $restResponse = $this->restResourceBuilder->createRestResponse();

        $restResource = $this->restResourceBuilder->createRestResource(
            HelloWorldConfig::RESOURCE_GLOSSARY,
            $glossaryTransfer->getKey(),
            $glossaryTransfer
        );

        $restResponse = $restResponse->addResource($restResource);

        return $restResponse;
    }
}
