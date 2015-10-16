<?php
class Field {
	var $id;
	var $type;
	var $idPrefix;
	var $class;
	var $activeClass;
	var $value;
	var $keys; // Array (for select drop down)
	var $values; //Array (for select drop down)
	var $onChange;
	var $onClick;
	var $onKeyPress;
	var $onKeyRelease;
	var $activeItem;
	
	function Field($id, $type, $class, $activeClass, $value, $onClick) {
		$this->id = $id;
		$this->type = $type;
		$this->class = $class;
		$this->activeClass = $activeClass;
		$this->value = $value;
		$this->onClick = $onClick;
	}
}
?>