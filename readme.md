Inteve\Forms
============

Controls for Nette\Forms.


Installation
------------

[Download a latest package](https://github.com/inteve/forms/releases) or use [Composer](http://getcomposer.org/):

```
composer require inteve/forms
```

Library requires PHP 5.6 or later.


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
