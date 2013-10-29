<?php
	class PageManager{
		private $language = 'nl';

		function PageManager(){
			$this->setLanguage();
		}

		function drawHeader($type = 'default'){
			Base::get('Layout')->drawHeader($type);
		}

		function drawFooter($type = 'default'){
			Base::get('Layout')->drawFooter($type);
		}

		function setLanguage($language = null){
			if($language !== null) $this->language = $language;
			include_once(realpath(dirname(__FILE__)). '/../languages/' .$this->language. '.php');
		}

		function getUserType(){
			return $_SESSION['FontysPSE']['Login']['UserType'];
		}

		function redirect($url){
			header('location: ' .$url);
			$this->close();
		}

		function close(){
			exit;
		}
	}
?>