<?php

	namespace Inteve\Forms;

	use Nette;


	interface IFormFactory
	{
		/**
		 * @return Nette\Forms\Form
		 */
		function create();
	}
