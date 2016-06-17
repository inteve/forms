<?php

	namespace Inteve\Forms\Controls;


	class TextInput extends \Nette\Forms\Controls\TextInput
	{
		public function getValue()
		{
			return $this->value !== '' ? $this->value : NULL;
		}
	}
