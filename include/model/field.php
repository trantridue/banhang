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
	
//	function Field($id, $type, $idPrefix, $class, $activeClass, $value, $keys, $values, $onClick, $onChange) {
//		$this->id = $id;
//		$this->type = $type;
//		$this->idPrefix = $idPrefix;
//		$this->class = $class;
//		$this->activeClass = $activeClass;
//		$this->value = $value;
//		$this->keys = $keys;
//		$this->values = $values;
//		$this->onClick = $onClick;
//		$this->onChange = $onChange;
//	}
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