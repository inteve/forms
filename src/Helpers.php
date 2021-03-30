<?php

	namespace Inteve\Forms;


	class Helpers
	{
		public function __construct()
		{
			throw new StaticClassException('This is static class.');
		}


		/**
		 * @param  string $value
		 * @return int|NULL
		 */
		public static function toInt($value)
		{
			$value = trim($value);

			if ($value !== '') {
				$value = ltrim($value, '0');
				$value = $value !== '' ? $value : '0';
			}

			$tmp = abs((int) $value);
			return ((string) $tmp) === $value ? $tmp : NULL;
		}
	}
