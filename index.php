<?php
	include_once('base/base.php');
	/** @var PageManager $pageManager */
	$pageManager = Base::get('PageManager');

	//Check login status
	if(!Base::get('Login')->isLoggedIn() && $_GET['p'] != 'login'){
		$pageManager->redirect('login');
	}

	//Get page
	$currentPage = $_GET['p'];

	//Include page
	$pageContent = '';
	if(file_exists('pages/' .$currentPage. '.php')){
		include('pages/' .$currentPage. '.php');
	}
	else{
		echo fLang('pagenotfound');
	}

	//Page
	if($currentPage == 'login') $pageManager->drawHeader('login');
	else $pageManager->drawHeader();
	echo $pageContent;
	if($currentPage == 'login') $pageManager->drawFooter('login');
	else $pageManager->drawFooter();
?>