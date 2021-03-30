Inteve\Forms
============

[![Tests Status](https://github.com/inteve/forms/workflows/Tests/badge.svg)](https://github.com/inteve/forms/actions)

Controls for Nette\Forms.


Installation
------------

[Download a latest package](https://github.com/inteve/forms/releases) or use [Composer](http://getcomposer.org/):

```
composer require inteve/forms
```

Library requires PHP 5.6 or later.


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


------------------------------

License: [New BSD License](license.md)
<br>Author: Jan Pecha, https://www.janpecha.cz/
