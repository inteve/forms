Inteve\Forms
============

[![Build Status](https://github.com/inteve/forms/workflows/Build/badge.svg)](https://github.com/inteve/forms/actions)
[![Downloads this Month](https://img.shields.io/packagist/dm/inteve/forms.svg)](https://packagist.org/packages/inteve/forms)
[![Latest Stable Version](https://poser.pugx.org/inteve/forms/v/stable)](https://github.com/inteve/forms/releases)
[![License](https://img.shields.io/badge/license-New%20BSD-blue.svg)](https://github.com/inteve/forms/blob/master/license.md)

Controls for Nette\Forms.

<a href="https://www.janpecha.cz/donate/"><img src="https://buymecoffee.intm.org/img/donate-banner.v1.svg" alt="Donate" height="100"></a>


Installation
------------

[Download a latest package](https://github.com/inteve/forms/releases) or use [Composer](http://getcomposer.org/):

```
composer require inteve/forms
```

Library requires PHP 8.0 or later.


DateInput
---------

```php
$form['date'] = new Inteve\Forms\DateInput('Date:', 'Error message for invalid date.');
$form['date']->setDefaultValue(new \DateTimeImmutable('2018-01-01 20:18'));
$form['date']->setDefaultValue(new \DateTime('2018-01-01 20:18'));

$form['date']->getValue(); // DateTimeImmutable|NULL
```


DateTimeInput
-------------

```php
$form['datetime'] = new Inteve\Forms\DateTimeInput('Datetime:', 'Error message for invalid datetime.');
$form['datetime']->setDefaultValue(new \DateTimeImmutable('2018-01-01 20:18'));
$form['datetime']->setDefaultValue(new \DateTime('2018-01-01 20:18'));

$form['datetime']->getValue(); // DateTimeImmutable|NULL
```

You can set timezone for HTML value.

```php
$form['datetime'] = new Inteve\Forms\DateTimeInput('Datetime:', $errorMessage, 'Europe/Prague');
```


TimeInput
---------

```php
$form['time'] = new Inteve\Forms\TimeInput('Time:', 'Error message for invalid time.');
$form['time']->setDefaultValue(new \DateTimeImmutable('2018-01-01 20:18'));
$form['time']->setDefaultValue(new \DateTime('2018-01-01 20:18'));
$form['time']->setDefaultValue(new \DateInterval('PT20H18M'));

$form['time']->getValue(); // DateInterval|NULL
```


Others
------

* HtmlInput
* UrlPathInput
* UrlSlugInput


------------------------------

License: [New BSD License](license.md)
<br>Author: Jan Pecha, https://www.janpecha.cz/
