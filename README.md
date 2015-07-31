# Caldera Community Framework

**Just Another PHP Framework...** [CCF](http://framework.calderams.com) is the base of many of our products, and so, it is just another everyday PHP framework.

[Discussion Forum](http://calderams.com/forum) -
[Twitter](http://twitter.com/CalderaMS) -
[Contact](mailto:framework@calderams.org)

[![Gitter](https://badges.gitter.im/Join%20Chat.svg)](https://gitter.im/CalderaMS/CalderaPublic)

## Goals

- **Fast and simple.** No clutter, no bloat, no complex dependencies. CCF is built with PHP so it's quick and easy to deploy. Allowing you to develop web applications quickly and efficiently.
- **Templating & Skins.** Caldera Community Framework comes with a built in templating engine and skins, making themeing a cinch.
- **Powerful and extensible.** Customise, extend, and integrate CCF to suit your needs. CCF's architecture is amazingly flexible, prioritising comprehensive APIs and great documentation.
- **Authentication & Permissions.** Caldera Community Framework comes with powerful user authentication and permissions, saving you time, while providing a base to extend. Should you wish to not use this feature, simply don't use it, or just remove the package...simple.

## Installation

**Caldera Community Framework is currently in development and will be ready to use later this year.**

## Contributing

We appreciate all contributions, big or small. However, we will only accept those that follow our guidelines.

Coding Style (Please note, all code must also adhere to [PSR-1](https://github.com/php-fig/fig-standards/blob/master/accepted/PSR-1-basic-coding-standard.md)): [PSR-2](https://github.com/php-fig/fig-standards/blob/master/accepted/PSR-2-coding-style-guide.md):

 ```php
<?php
namespace Vendor\Package;

use FooInterface;
use BarClass as Bar;
use OtherVendor\OtherPackage\BazClass;

class Foo extends Bar implements FooInterface
{
    public function sampleFunction($a, $b = null)
    {
        if ($a === $b) {
            bar();
        } elseif ($a > $b) {
            $foo->bar($arg1);
        } else {
            BazClass::bar($arg2, $arg3);
        }
    }

    final public static function bar()
    {
        // method body
    }
 }

 ```



Bug reports should go in [CalderaMS/framework](https://github.com/CalderaMS/framework/issues).


**If you find a security vulnerability within Caldera Community Framework please email security@calderams.com**

