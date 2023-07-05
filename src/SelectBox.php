<?php

	namespace Inteve\Forms;

	use Nette;


	class SelectBox extends Nette\Forms\Controls\SelectBox
	{
		/** @var callable|NULL */
		private $itemsProvider;


		/**
		 * @param string|NULL $label
		 * @param array<mixed>|null $items
		 */
		public function __construct($label = NULL, array $items = NULL)
		{
			parent::__construct($label, $items);
			$this->control->appendAttribute('class', 'input--selectbox');
		}


		/**
		 * @param  string $url
		 * @return static
		 */
		public function setRemoteSource($url, callable $itemsProvider)
		{
			$this->setHtmlAttribute('data-source-url', $url);
			$this->itemsProvider = $itemsProvider;
			return $this;
		}


		/**
		 * @param  string $url
		 * @return static
		 */
		public function enableCreate($url)
		{
			$this->setHtmlAttribute('data-create-url', $url);
			return $this;
		}


		public function loadHttpData()
		{
			parent::loadHttpData();
			$value = is_string($this->value) ? $this->value : '';

			if ($this->itemsProvider !== NULL && $value !== '') {
				$items = call_user_func($this->itemsProvider, $value);
				$this->setItems($items);
			}
		}
	}
