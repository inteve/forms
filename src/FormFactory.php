<?php

	namespace Inteve\Forms;

	use Nette;
	use Nette\Application\UI\Form;


	class FormFactory extends Nette\Object
	{
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
