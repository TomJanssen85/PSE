<?php
	class Layout{
		function Layout(){

		}

		function drawHeader($type){
			echo '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">';
			echo '<html xmlns="http://www.w3.org/1999/xhtml">';
				echo '<head>';
					echo '<title>' .fLang('applicationname'). '</title>';
					echo '<link type="text/css" href="css/main.css" rel="stylesheet" />';
					echo '<link type="text/css" href="css/jquery-ui.css" rel="stylesheet" />';
					echo '<script type="text/javascript" src="js/jquery.js"></script>';
					echo '<script type="text/javascript" src="js/jquery-ui.js"></script>';
					echo '<script type="text/javascript" src="js/main.js"></script>';
				echo '</head>';
				echo '<body>';
					echo '<a href="catalog">' .fLang('catalog'). '</a> | ';
					echo '<a href="shoppingcart">' .fLang('shoppingcart'). '</a> | ';
					echo '<a href="logout">' .fLang('logout'). '</a>';
					echo '<hr />';
		}

		function drawFooter($type){
				echo '</body>';
			echo '</html>';
		}
	}