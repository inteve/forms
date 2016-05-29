<?php

	namespace Inteve\Forms;


	class Filters
	{
		/**
		 * @param  string
		 * @return string|NULL
		 */
		public static function text($value)
		{
			if ($value === '') {
				return NULL;
			}
			return $value;
		}
	}
