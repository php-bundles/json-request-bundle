Symfony JsonRequest Bundle
==========================

[![SensioLabsInsight][sensiolabs-insight-image]][sensiolabs-insight-link]

[![Build Status][testing-image]][testing-link]
[![Scrutinizer Code Quality][scrutinizer-code-quality-image]][scrutinizer-code-quality-link]
[![Code Coverage][code-coverage-image]][code-coverage-link]
[![Total Downloads][downloads-image]][package-link]
[![Latest Stable Version][stable-image]][package-link]
[![License][license-image]][license-link]

What is JsonRequest Bundle?
---------------------------
This bundle will help you to work with json requests as standard requests without using «crutches».
If previously for fetching of data from the request you did like this:
`$data = json_decode($request->getContent())`,
it is now in this already there is no need to.

For example when sending json-request from AngularJS or etc.
Early:
``` php
public function indexAction(Request $request)
{
    $data = json_decode($request->getContent());

    // uses request data
    $name = isset($data['name']) ? $data['name'] : null;
}
```

Now you can work with json-request as with standard request:
``` php
public function indexAction(Request $request)
{
    $name = $request->get('name');
}
```

Installation
------------
* Require the bundle with composer:

``` bash
composer require symfony-bundles/json-request-bundle
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

* Configure the bundle in your config.yml (optional).

Defaults configuration:
``` yml
sb_json_request:
    listener:
        request_transformer: "SymfonyBundles\JsonRequestBundle\EventListener\RequestTransformerListener"
```

[package-link]: https://packagist.org/packages/symfony-bundles/json-request-bundle
[license-link]: https://github.com/symfony-bundles/json-request-bundle/blob/master/LICENSE
[license-image]: https://poser.pugx.org/symfony-bundles/json-request-bundle/license
[testing-link]: https://travis-ci.org/symfony-bundles/json-request-bundle
[testing-image]: https://travis-ci.org/symfony-bundles/json-request-bundle.svg?branch=master
[stable-image]: https://poser.pugx.org/symfony-bundles/json-request-bundle/v/stable
[downloads-image]: https://poser.pugx.org/symfony-bundles/json-request-bundle/downloads
[sensiolabs-insight-link]: https://insight.sensiolabs.com/projects/dea68633-2368-4e12-a516-89157d2c6b07
[sensiolabs-insight-image]: https://insight.sensiolabs.com/projects/dea68633-2368-4e12-a516-89157d2c6b07/big.png
[code-coverage-link]: https://scrutinizer-ci.com/g/symfony-bundles/json-request-bundle/?branch=master
[code-coverage-image]: https://scrutinizer-ci.com/g/symfony-bundles/json-request-bundle/badges/coverage.png?b=master
[scrutinizer-code-quality-link]: https://scrutinizer-ci.com/g/symfony-bundles/json-request-bundle/?branch=master
[scrutinizer-code-quality-image]: https://scrutinizer-ci.com/g/symfony-bundles/json-request-bundle/badges/quality-score.png?b=master
