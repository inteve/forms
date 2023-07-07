<?php

	declare(strict_types=1);

	namespace Inteve\Forms;

	use Nette;


	interface IFormFactory
	{
		/**
		 * @return Nette\Application\UI\Form
		 */
		function create();
	}
