Symfony JsonRequest Bundle
==========================

[![SensioLabsInsight][sensiolabs-insight-image]][sensiolabs-insight-link]

[![Build Status][testing-image]][testing-link]
[![Scrutinizer Code Quality][scrutinizer-code-quality-image]][scrutinizer-code-quality-link]
[![Code Coverage][code-coverage-image]][code-coverage-link]

Installation
------------
* Require the bundle with composer:

``` bash
composer require symfony-bundles/testing-json-request-bundle
```

* Enable the bundle in the kernel:

``` php
public function registerBundles()
{
    $bundles = [
        // ...
        new SymfonyBundles\JsonRequestBundle\SymfonyBundlesJsonRequestBundle(),
        // ...
    ];
    ...
}
```

* Configure the bundle in your config.yml.

Defaults configuration:
``` yml
sb_json_request:
    listener:
        request_transformer: "SymfonyBundles\JsonRequestBundle\EventListener\RequestTransformerListener"
```

[testing-link]: https://travis-ci.org/symfony-bundles/testing-json-request-bundle
[testing-image]: https://travis-ci.org/symfony-bundles/testing-json-request-bundle.svg?branch=master
[code-coverage-link]: https://scrutinizer-ci.com/g/symfony-bundles/testing-json-request-bundle/?branch=master
[code-coverage-image]: https://scrutinizer-ci.com/g/symfony-bundles/testing-json-request-bundle/badges/coverage.png?b=master
[scrutinizer-code-quality-link]: https://scrutinizer-ci.com/g/symfony-bundles/testing-json-request-bundle/?branch=master
[scrutinizer-code-quality-image]: https://scrutinizer-ci.com/g/symfony-bundles/testing-json-request-bundle/badges/quality-score.png?b=master
