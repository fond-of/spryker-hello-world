<?php

declare(strict_types=1);

namespace FondOfSpryker\Glue\HelloWorld;

use Spryker\Glue\Kernel\AbstractBundleConfig;

class HelloWorldConfig extends AbstractBundleConfig
{
    public const RESOURCE_HELLO_WORLD = 'hello-world';
    public const CONTROLLER_HELLO_WORLD = 'hello-world-resource';

    public const RESPONSE_CODE_TRANSLATION_NOT_FOUND = 4004;
    public const RESPONSE_DETAILS_TRANSLATION_NOT_FOUND = "Die Übersetzung wurde nicht gefunden.";

    public const RESOURCE_GLOSSARY = "glossary";

    public const RESOURCE_CUSTOMERS = 'customers';
}
