<?php

	declare(strict_types=1);

	namespace Inteve\Forms;


	class Helpers
	{
		public function __construct()
		{
			throw new StaticClassException('This is static class.');
		}


		public static function toInt(string $value): ?int
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
