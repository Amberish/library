<?php

class Encryption {

	private static $_key = "Password is to be (en/de)crypted",
				   $_cipher = MCRYPT_RIJNDAEL_256,
				   $_mcrypt_mode = MCRYPT_MODE_CBC;

	public static function encrypt($data) {
		return base64_encode(mcrypt_encrypt(self::getCipher(), self::getHashKey(), $data, self::getMcryptMode(), md5(self::getHashKey())));
	}

	public function decrypt($encrypt_data) {
		return rtrim(mcrypt_decrypt(self::getCipher(), self::getHashKey(), base64_decode($encrypt_data), self::getMcryptMode(), md5(self::getHashKey())), "\0");
	}

	private static function getCipher() {
		return self::$_cipher;
	}

	private static function getHashKey() {
		return md5(self::$_key);
	}

	private static function getMcryptMode() {
		return self::$_mcrypt_mode;
	}
}
