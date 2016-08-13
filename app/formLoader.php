<?php

namespace App;

class formLoader {

	var $form_data;
	var $action;

	public function __construct($form_json, $form_action) {
		$this->form_data = json_decode(str_replace('\\', '', $form_json));
		$this->action = $form_action;
	}
	public function render_form() {
		if( empty($this->form_data) || empty($this->action) ) {
			throw new Exception("Error Processing Request", 1);
		}
		$fields = '';
		$intCounter = 0;
		foreach ($this->form_data->fields as $field) {
			$id[$intCounter] = $this->encode_element_title($field->title);
			$intCounter++;
		}
		return $id;
	}
	public function getElementType(){
		if( empty($this->form_data) || empty($this->action) ) {
			throw new Exception("Error Processing Request", 1);
		}
		$fields = '';
		$intCounter = 0;
		foreach ($this->form_data->fields as $field) {
			$type[$intCounter] = $field->type;
			$intCounter++;
		}
		return $type;	
	}
	private function encode_element_title($title) {
		$str = str_replace(' ', '_', strtolower($title));
		$str = preg_replace("/[^a-zA-Z0-9.-_]/", "", $str);
		$str = preg_replace("/[9.]/", "_", $str); 			// pattern 3. will become 3_
		$str = htmlentities($str, ENT_QUOTES, 'UTF-8');
		$str = html_entity_decode($str, ENT_QUOTES, 'UTF-8');
		return $str;
	}
	public function form_title(){
		return $this->form_data->title;
	}
	public function form_description(){
		return $this->form_data->description;
	}
}