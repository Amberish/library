<?php

class HTML {

	private static function attrBuilder($attr) {
		$attrString = '';
		
		foreach ($attr as $key => $value) {

			if($key != 'selected') {
				$attrString .= $key . '=' . '"'. $value. '" ';
			}

		}

		return $attrString;
	}

	/*attrSelect and attrOption are for attributes and contain all html attributes in array form*/
	public static function dropDown($list, $selected = 1, $attrSelect = array(), $attrOption = array()) {
		if(count($attrSelect) != 0) {
			
			$option = '';
			$select = '';

			$selectedEl = $selected; // $attrOption['selected'];
			$count = 1;

			$attrSelect = self::attrBuilder($attrSelect);
			$attrOpt = self::attrBuilder($attrOption);
			foreach ($list as $key => $value) {
				if(!is_numeric($key)) {
					$valueString = 'value =' . '"' . $key . '"';
				} else {
					$valueString = 'value =' . '"' . $value . '"';
				}

				$attr = $attrOpt . $valueString;

				if($count == $selectedEl) {
					$attr .= ' selected ';
				}				
				
				$option .= "\t" . '<option ' . $attr . '>' . $value . '</option>' . "\n";

				$count++;
			}

			$select .= '<select ' . $attrSelect . '>' . "\n" . $option . '</select>';
		}

		return $select;
	}


}