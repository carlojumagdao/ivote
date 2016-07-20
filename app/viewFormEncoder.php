<?php

namespace App;

class viewFormEncoder {

	/**
	 * Form structure
	 *
		 * @var object
	 **/
	var $form_data;

	/**
	 * Form action
	 *
	 * @var string
	 **/
	var $action;

	var $strMemCode;
	var $strMemFname;
	var $strMemMname;
	var $strMemLname;
	var $strMemEmail;
	var $arrFieldName= array (' ');
	var $arrFieldData= array (' ');
	/**
	 * Constructor
	 *
	 * @param string $form_json
	 * @return void
	 * @access public
	 **/
	public function __construct($form_json, $form_action,$strMemCode,$strMemFname,$strMemMname,$strMemLname,$strMemEmail,$arrFieldName,$arrFieldData)
	{
		$this->form_data = json_decode(str_replace('\\', '', $form_json));
		$this->action = $form_action;
		$this->strMemCode = $strMemCode;
		$this->strMemFname = $strMemFname;
		$this->strMemMname = $strMemMname;
		$this->strMemLname = $strMemLname;
		$this->strMemEmail = $strMemEmail;
		$this->arrFieldName = $arrFieldName;
		$this->arrFieldData = $arrFieldData;
	}

	/**
	 * Render the form
	 *
	 * @return void
	 * @access public 
	 **/
	public function render_form()
	{
		if( empty($this->form_data) || empty($this->action) ) {
			throw new Exception("Error Processing Request", 1);
		}
		$fields = '';

		foreach ($this->form_data->fields as $field) {
			
			// Single line text default
			if($field->type == 'element-single-line-text-default' ) {
				$fields .= $this->element_single_line_text($field);
			}

			// Single line text
			if($field->type == 'element-single-line-text' ) {
				$fields .= $this->element_single_line_text($field);
			}

			// Number
			if($field->type == 'element-number') {
				$fields .= $this->element_number($field);
			}

			// Paragraph text
			if($field->type == 'element-paragraph-text') {
				$fields .= $this->element_paragraph_text($field);
			}

			// Checkboxes
			if($field->type == 'element-checkboxes') {
				$fields .= $this->element_checkboxes($field);
			}

			// Multiple choice
			if($field->type == 'element-multiple-choice') {
				$fields .= $this->element_multiple_choice($field);
			}

			// Dropdown
			if($field->type == 'element-dropdown') {
				$fields .= $this->element_dropdown($field);
			}

			// Section break
			if($field->type == 'element-section-break') {
				$fields .= $this->element_section_break($field);
			}

			// Email
			if($field->type == 'element-email') {
				$fields .= $this->element_email($field);
			}

		}

		$form = $this->open_form($fields);
		return $form;
	}

	/**
	 * Render the form header
	 *
	 * @param object $fields
	 * @return string $html
	 * @access private 
	 **/
	private function open_form($fields)
	{
		$html = sprintf('<form action="%s" method="post" accept-charset="utf-8" role="form"  >', $this->action);
		$html .= $fields;
		//$html .= '<button type="submit" class="btn btn-primary">Submit</button>';
		$html .= '</form>';
		return $html;
	}

	/**
	 * Encode element title
	 *
	 * @param string $title
	 * @return string $str
	 * @access private 
	 **/
	private function encode_element_title($title)
	{
		$str = str_replace(' ', '_', strtolower($title));
		$str = preg_replace("/[^a-zA-Z0-9.-_]/", "", $str);
		$str = htmlentities($str, ENT_QUOTES, 'UTF-8');
		$str = html_entity_decode($str, ENT_QUOTES, 'UTF-8');

		return $str;
	}

	/**
	 * Get formatted label for form element
	 *
	 * @param string $id
	 * @param string $title
	 * @param mixed $required
	 * @return string
	 * @access private
	 **/
	private function make_label($id, $title, $required)
	{
		if( $required ) {
			$html = sprintf('<label for="%s">%s <span style="color: red">*</span></label>', $id, $title);
		} else {
			$html = sprintf('<label for="%s">%s </label>', $id, $title);
		}

		return $html;
	}

	/**
	 * Render single line text
	 *
	 * @param object $field
	 * @return string $html
	 * @access private 
	 **/
	private function element_single_line_text($field)
	{
		$id = $this->encode_element_title($field->title);
		$required = ($field->required) ? 'required' : FALSE;
		$html = '<div class="form-group">';
		$html .= $this->make_label($id, $field->title, $required);
	    if($id == "member_id"){
	    	$html .= sprintf('<input type="text" name="%s" id="%s" class="form-control validate %s" value="%s" readonly>', $id, $id, $required,$this->strMemCode);
	    } else if($id == "first_name"){
	    	$html .= sprintf('<input type="text" name="%s" id="%s" class="form-control validate %s" value="%s" readonly>', $id, $id, $required,$this->strMemFname);
	    } else if($id == "middle_name"){
	    	$html .= sprintf('<input type="text" name="%s" id="%s" class="form-control validate %s" value="%s" readonly>', $id, $id, $required,$this->strMemMname);
	    } else if($id == "last_name"){
	    	$html .= sprintf('<input type="text" name="%s" id="%s" class="form-control validate %s" value="%s" readonly>', $id, $id, $required,$this->strMemLname);
	    } else if($id == "email"){
	    	$html .= sprintf('<input type="text" name="%s" id="%s" class="form-control validate %s" value="%s" readonly>', $id, $id, $required,$this->strMemEmail);
	    } 
	    else {
	    	$intCounter = 0;
	    	$blHasData = false;
	    	foreach ($this->arrFieldName as $value) {
	    		if($id == "$value"){
			    	$html .= sprintf('<input type="text" name="%s" id="%s" class="validate %s" value="%s" readonly>', $id, $id, $required,$this->arrFieldData[$intCounter]);
			    	$blHasData = true;
			    	break;
			    }
			    $intCounter++;	    	
	    	}
	    	if(!$blHasData){
	    		$html .= sprintf('<input type="text" name="%s" id="%s" class="validate %s" readonly>', $id, $id, $required);
	    	}
	    }
	  	$html .= '</div>';
	  	return $html;
	}

	/**
	 * Render number
	 *
	 * @param object $field
	 * @return string $html
	 * @access private
	 **/
	private function element_number($field)
	{
		$id = $this->encode_element_title($field->title);
		$required = ($field->required) ? 'required' : FALSE;

		$numvalue = " ";
		$intCounter = 0;
		foreach ($this->arrFieldName as $numvalue) {
			if($numvalue == $id){
				$numvalue = $this->arrFieldData[$intCounter];
				break;
			}
			$intCounter++;
		}


		$html = '<div class="form-group">';
		$html .= $this->make_label($id, $field->title, $required);
	    $html .= sprintf('<input type="number" name="%s" id="%s" class="form-control %s" value="%s" readonly>', $id, $id, $required,$numvalue);
	  	$html .= '</div>';
	  	//echo "$id<br/>";
	  	return $html;
	}

	/**
	 * Render email
	 *
	 * @param object $field
	 * @return string $html
	 * @access private
	 **/
	private function element_email($field)
	{
		$id = $this->encode_element_title($field->title);
		$required = ($field->required) ? 'required' : FALSE;
		
		$html = '<div class="form-group">';
		$html .= $this->make_label($id, $field->title, $required);
	    $html .= sprintf('<input type="email" name="%s" id="%s" class="form-control" value="%s" %s readonly>', $id, $id, $this->strMemEmail, $required);
	  	$html .= '</div>';
	  	//echo "$id<br/>";
	  	return $html;
	}

	/**
	 * Render paragraph text
	 *
	 * @param object $field
	 * @return string $html
	 * @access private
	 **/
	private function element_paragraph_text($field)
	{
		$id = $this->encode_element_title($field->title);
		$required = ($field->required) ? 'required' : FALSE;
		$txtvalue = " ";
		$intCounter = 0;
		foreach ($this->arrFieldName as $textarea) {
			if($textarea == $id){
				$txtvalue = $this->arrFieldData[$intCounter];
				break;
			}
			$intCounter++;
		}

		$html = '<div class="input-field col s12">';
		$html .= $this->make_label($id, $field->title, $required);
	    $html .= sprintf('<textarea id="%s" name="%s" class="materialize-textarea %s" rows="3" value="%s" readonly >%s</textarea>', $id, $id, $required, $required,$txtvalue);
	  	$html .= '</div>';
	  	return $html;
	}

	/**
	 * Checkboxes
	 *
	 * @param object $field
	 * @return string $html
	 * @access private
	 **/
	private function element_checkboxes($field)
	{
		error_log('message');
		
		$id = $this->encode_element_title($field->title);
		$required = ($field->required) ? 'required' : FALSE;

		$html = '<div class="form-group">';
		$html .= $this->make_label($id, $field->title, $required);
		
	    // Render choices
		for($i=0; $i < count($field->choices); $i++) {
			// $checked = $field->choices[$i]->checked ? "checked" : '';
			$value = $field->choices[$i]->value;
			$checked = ' ';
	    	foreach ($this->arrFieldData as $FieldValue) {
	    		if ($FieldValue == $value) {
	    			$checked = "checked";
	    			break;
	    		}else{
	    			$checked = ' '; 
	    		}
	    	}
			$html .= '<div class="checkbox"><label>';
			$html .= sprintf('<input type="checkbox" disabled="disabled" class="flat-red" name="%s[]" id="%s-%d" value="%s readonly" %s > %s ', $id, $id, $i, $field->choices[$i]->value, $checked, $field->choices[$i]->title);
			$html .= '</label></div>';
		}

	  	$html .= '</div>';
		//echo "$id<br/>";
	  	return $html;
	}

	/**
	 * Mutliple choice
	 *
	 * @param object $field
	 * @return string $html
	 * @access private
	 **/
	private function element_multiple_choice($field)
	{
		$id = $this->encode_element_title($field->title);
		$required = ($field->required) ? 'required' : FALSE;

		$html = '<div class="form-group">';
		$html .= $this->make_label($id, $field->title, $required);
		
	    // Render choices
		for($i=0; $i < count($field->choices); $i++) {
			// $checked = $field->choices[$i]->checked ? "checked" : '';
			$value = $field->choices[$i]->value;
			$checked = ' ';
	    	foreach ($this->arrFieldData as $FieldValue) {
	    		if ($FieldValue == $value) {
	    			$checked = "checked";
	    			break;
	    		}else{
	    			$checked = ' '; 
	    		}
	    	}
	    	$html .= '<div class="radio">';
			$html .= '<label>';
			$html .= sprintf('<input type="radio" class="flat-red" disabled="disabled" name="%s" id="%s_%d" value="%s" %s >', $id, $id, $i, $field->choices[$i]->value, $checked);
			$html .= sprintf(' %s',$field->choices[$i]->value);
			$html .= '</label>';
			$html .= '</div>';
		}

	  	$html .= '</div>';
	  	//echo "$id<br/>";
	  	return $html;
	}

	/**
	 * Render dropdown
	 *
	 * @param object $field
	 * @return string $html
	 * @access private
	 **/
	private function element_dropdown($field)
	{
		$id = $this->encode_element_title($field->title);
		$required = ($field->required) ? 'required' : FALSE;

		$html = '<div class="form-group">';
		$html .= $this->make_label($id, $field->title, $required);
	    $html .= sprintf('<select name="%s" id="%s" class="form-control %s" disabled="disabled">', $id, $id, $required);
	    $html .= "<option selected='true' disabled='disabled'>-Select-</option>";

	    // Render choices
	    foreach ($field->choices as $choice) {
	    	$checked = ' ';
	    	foreach ($this->arrFieldData as $FieldValue) {
	    		if ($FieldValue == $choice->value) {
	    			$checked = "selected";
	    			break;
	    		}else{
	    			$checked = ' '; 
	    		}
	    	}
	    	$html .= sprintf('<option disabled="disabled" value="%s" %s>%s</option>', $choice->value, $checked, $choice->title);
	    }

	  	$html .= '</select></div>';
	  	return $html;
	  	echo "$html";
	}

	/**
	 * Section break
	 *
	 * @param object $field
	 * @return string $html
	 * @access private
	 **/
	private function element_section_break($field)
	{
		$html = '<div class="form-group section-break">';
		$html .= sprintf('<hr/><h4>%s</h4><p>%s</p>', $field->title, $field->description);
		$html .= '</div>';

		return $html;
	}

} // End formLoader.php