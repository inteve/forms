<?php

	namespace Inteve\Forms;

	use Nette;
	use Nette\Application\UI\Form;


	class FormFactory
	{
		use \Nette\SmartObject;


		/** @var callback[] */
		public $onCreate;


		/**
		 * @return Form
		 */
		public function create()
		{
			$form = new Form;
			$this->onCreate($form);
			return $form;
		}
	}
