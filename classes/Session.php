<?php

class Session {

	public static function exists($name){
		return (isset($_SESSION[$name])) ? true : false;	
	}

	/*3rd parameter account for encryption. If true then data is encrypted.*/
	public static function put($name, $value, $encrypt = false){
		
		if($encrypt){
			return $_SESSION[$name] = Encryption::encrypt($value);
		} 

		return $_SESSION[$name] = $value;
	}

	/*3rd parameter account for decryption. If true then data is decrypted.*/
	public static function get($name, $decrypt = false){
		if($decrypt){
			return Encryption::decrypt($_SESSION[$name]);
		}
		return $_SESSION[$name];
	}

	public static function delete($name){
		if(self::exists($name)){
			unset($_SESSION[$name]);
		}
	}

	public static function flash($name, $string = ''){
		if(self::exists($name)){
			$session = self::get($name);
			self::delete($name);
			return $session;
		} else{
			self::put($name, $string);
		}
	}
}