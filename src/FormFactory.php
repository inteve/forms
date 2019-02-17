<?php

	namespace Inteve\Forms;

	use Nette;


	class FormFactory
	{
		use \Nette\SmartObject;


		/**
		 * @return Nette\Application\UI\Form
		 */
		public function create()
		{
			return new Form;
		}
	}
