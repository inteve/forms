<?php

	namespace Inteve\Forms;

	use Nette\Application\UI\Form;


	class FormFactory implements IFormFactory
	{
		use \Nette\SmartObject;


		/**
		 * @return Form
		 */
		public function create()
		{
			return new Form;
		}
	}
