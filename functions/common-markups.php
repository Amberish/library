<?php

function displayErrors($errors, $type) {

	switch ($type) {
		case 'validation':
			foreach($errors as $error) {
				echo '<p style="color:maroon; ">*' . $error . '</p>';
			}
			break;
		
		default:
			foreach($errors as $error) {
				 echo $error, '<br>';
			}
			break;
	}
	

}