# Paginator Bundle for Symfony Framework #

[![CI](https://github.com/silpo-tech/PaginatorBundle/actions/workflows/ci.yml/badge.svg)](https://github.com/silpo-tech/PaginatorBundle/actions)
[![codecov](https://codecov.io/gh/silpo-tech/PagiratorBundle/graph/badge.svg)](https://codecov.io/gh/silpo-tech/PagiratorBundle)
[![License: MIT](https://img.shields.io/badge/License-MIT-yellow.svg)](https://opensource.org/licenses/MIT)

## Installation ##

Require the bundle and its dependencies with composer:

```bash
$ composer require silpo-tech/paginator-bundle
```

Register the bundle:

```php
// app/AppKernel.php

public function registerBundles()
{
    $bundles = array(
        ...
        new PabinatorBundle\PabinatorBundle()
    );
}
```

## Tests ##

```shell
composer test:run
```