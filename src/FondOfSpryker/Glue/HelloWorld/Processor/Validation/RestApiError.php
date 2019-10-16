<?php

namespace FondOfSpryker\Glue\HelloWorld\Processor\Validation;

use FondOfSpryker\Glue\HelloWorld\HelloWorldConfig;
use Generated\Shared\Transfer\RestErrorMessageTransfer;
use Spryker\Glue\GlueApplication\Rest\JsonApi\RestResponseInterface;
use Symfony\Component\HttpFoundation\Response;

class RestApiError implements RestApiErrorInterface
{
    /**
     * @param \Spryker\Glue\GlueApplication\Rest\JsonApi\RestResponseInterface $restResponse
     * @return \Spryker\Glue\GlueApplication\Rest\JsonApi\RestResponseInterface
     */
    public function addTranslationNotFoundError(RestResponseInterface $restResponse): RestResponseInterface
    {
        $restErrorMessageTransfer = (new RestErrorMessageTransfer())
            ->setCode(HelloWorldConfig::RESPONSE_CODE_TRANSLATION_NOT_FOUND)
            ->setStatus(Response::HTTP_NOT_FOUND)
            ->setDetail(HelloWorldConfig::RESPONSE_DETAILS_TRANSLATION_NOT_FOUND);

        return $restResponse->addError($restErrorMessageTransfer);
    }
}
