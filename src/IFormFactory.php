<?php

	namespace Inteve\Forms;

	use Nette;


	interface IFormFactory
	{
		/**
		 * @return Nette\Application\UI\Form
		 */
		function create();
	}
