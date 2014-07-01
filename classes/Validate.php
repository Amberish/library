<?php

class Validate {

	private $_passed = false,
			$_errors = array(),
			$_db = null;

	public function __construct(){
		$this->_db = DB::getInstance();
	}

	public function check($source, $items = array()){
		foreach($items as $item => $rules){

			if(isset($rules['label'])) {
				$label = $rules['label'];
			} else {
				$label = $item;
			}

			foreach($rules as $rule => $rule_value){
				$value = $source[$item];

				if($rule === 'required' && empty($value)){
					$this->addError("{$label} is required");
				}else if(!empty($value)){

					switch ($rule) {
						case 'min':
							if(strlen($value) < $rule_value){
								$this->addError("{$label} must be a minimum of {$rule_value} characters.");
							}
							break;

						case 'max':
							if(strlen($value) > $rule_value){
								$this->addError("{$label} must be a maximum of {$rule_value} characters.");
							}
							break;

						case 'matches':
							if($value != $source[$rule_value]){
								$labelValue = (isset($items[$rule_value]['label'])) ? $items[$rule_value]['label'] : $rule_value;
								$this->addError("{$labelValue} must match {$label}");
							}
							break;

						case 'unique':
							$check = $this->_db->get($rule_value, array($item, '=', $value));
							if($check->count()){
								$this->addError("{$label} already exists.");
							}
							break;
					}

				}
			}
		}

		if(empty($this->_errors)){
			$this->_passed = true;
		}

		return $this;
	}

	private function addError($error){
		$this->_errors[] = $error;
	}

	public function errors(){
		return $this->_errors;
	}

	public function passed(){
		return $this->_passed;
	}
}