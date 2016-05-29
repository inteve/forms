<?php

	namespace Inteve\Forms;

	use Nette\Forms\Controls as FormControls;


	class Controls
	{
		/**
		 * @param  string|NULL
		 * @param  int|NULL
		 * @return FormControls\TextInput
		 */
		public static function text($label = NULL, $maxLength = NULL)
		{
			$control = new FormControls\TextInput($label, $maxLength);

			$control->addFilter(array('Inteve\Forms\Filters', 'text'));
			return $control;
		}
	}
