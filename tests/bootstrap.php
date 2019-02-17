<?php

require __DIR__ . '/../vendor/autoload.php';

Tester\Environment::setup();


function test($cb)
{
	$cb();
}


function getHtmlValue($input)
{
	$form = new Nette\Forms\Form;
	$form['test'] = $input;
	$value = $input->getControl()->value;
	unset($form['test']);
	return $value;
}


function getPostValue($input, $postValue)
{
	$_SERVER['REQUEST_METHOD'] = 'POST';
	$_POST = [
		'test' => $postValue,
	];
	$_FILES = [];

	$form = new Nette\Forms\Form;
	$form['test'] = $input;
	$value = $input->getValue();
	unset($form['test']);
	return $value;
}