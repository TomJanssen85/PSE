<?php
	class Encryption{
		private $encryptionWords = array(
			'username' => 'aslkdf#908as$2oi0sad()@oijasd.>A<Sj',
			'password' => 'okejljoiuad#@NSf08923llksadjf-laskd'
		);
		private $sAlgorithm = 'blowfish';
        private $sMode = 'cbc';
        private $sIv = '81628100';
        private $oEncrypter;
        private $iKeySize;
        private $sKey;

		//Initialize
		public function Encryption(){
            
		}
		
		private function initializeEncryptionModule($stringType){
            $this->oEncrypter = null;
            $this->iKeySize = null;
            $this->sKey = null;
            $this->oEncrypter = mcrypt_module_open($this->sAlgorithm, '', $this->sMode, '');
            $this->iKeySize = mcrypt_enc_get_key_size($this->oEncrypter);
            $this->sKey = substr($this->encryptionWords[$stringType], 0, $this->iKeySize);
            mcrypt_generic_init($this->oEncrypter, $this->sKey, $this->sIv);
        }

		//Encrypt password
		public function Encrypt($string, $stringType){
			if($string == '') return $string;
			$this->initializeEncryptionModule($stringType);
			$encryptedString = mcrypt_generic($this->oEncrypter, $string);
            $encryptedString = base64_encode($encryptedString);
            return trim($encryptedString);
		}

		//Decrypt password
		public function Decrypt($string, $stringType){
			if($string == '') return $string;
			$this->initializeEncryptionModule($stringType);
			$decryptedString = base64_decode($string);
            $decryptedString = mdecrypt_generic($this->oEncrypter, $decryptedString);
            return trim($decryptedString);
		}
	}