<?php
	/** @var PageManager $pageManager */
	if($pageManager->getUserType() != 0) $pageManager->redirect('logout');

	//Check if login is submitted
	if(isset($_POST['form_submitted'])){
		if(Base::get('Login')->userLogin($_POST['username'], $_POST['password'])){
			$pageManager->redirect('menu');
		}
		else{
			$error = fLang('wronguserpass'). '.';
		}
	}

	$pageContent .= '<div class="center-div center-block">';
		$pageContent .= '<h2>' .fLang('login'). '</h2>';
		$pageContent .= '<form method="post">';
			$pageContent .= '<input type="hidden" name="form_submitted" value="1" />';
			$pageContent .= '<table>';
				$pageContent .= '<tr><td>' .fLang('username'). ':</td><td class="margin"></td><td><input type="text" name="username" /></td></tr>';
				$pageContent .= '<tr><td>' .fLang('password'). ':</td><td></td><td><input type="password" name="password" /></td></tr>';
				$pageContent .= '<tr><td></td><td></td><td><input type="submit" value="' .fLang('login'). '" /></td></tr>';
			$pageContent .= '</table>';
			if(isset($error)) $pageContent .= $error;
		$pageContent .= '</form>';
	$pageContent .= '</div>';
?>