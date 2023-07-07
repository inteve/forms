<?php

	declare(strict_types=1);

	namespace Inteve\Forms;

	use Nette\Application\UI\Form;


	class FormFactory implements IFormFactory
	{
		use \Nette\SmartObject;


		public function create(): Form
		{
			return new Form;
		}
	}
