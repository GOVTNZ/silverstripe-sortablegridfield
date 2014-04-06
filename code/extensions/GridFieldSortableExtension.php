<?php

class GridFieldSortableExtension extends DataExtension {

	private $sortField;

	public function __construct($sortField = 'SortOrder') {
		parent::__construct();

		$this->sortField = $sortField;
	}

	public static function get_extra_config($class, $extension, $args) {
		return array(
			'db' => array(
				$args[0] => 'Int'
			)
		);
	}

	public function onBeforeWrite() {
		if ($this->owner->ID == 0) {
			$maxSortOrderValue = $this->getMaxSortOrderValue();

			$sortField = $this->sortField;
			$this->owner->$sortField = ($maxSortOrderValue + 1);
		}
	}

	private function getMaxSortOrderValue() {
		$class = $this->ownerBaseClass;

		return $class::get()->max($this->sortField);
	}

}
