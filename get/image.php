<?php
	include_once('../base/base.php');
	/** @var PageManager $pageManager */
	$pageManager = Base::get('PageManager');

	//Check login status
	if(!Base::get('Login')->isLoggedIn() && $_GET['p'] != 'login'){
		$pageManager->redirect('login');
	}

	$width = (isset($_GET['width']) ? $_GET['width'] : 500);
	$height = (isset($_GET['height']) ? $_GET['height'] : 500);

	$image = Base::get('Images')->get(1, array('ImageID' => $_GET['id']));
	$image = $image[0];
	if(isset($_GET['type']) && $_GET['type'] == 'sizeonly'){
		echo json_encode(Base::get('ImageEditor')->resizeImage($image['Filename'], $image['ImageLR'], $width, $height, true, true));
	}
	else{
		$image['ImageLR'] = Base::get('ImageEditor')->resizeImage($image['Filename'], $image['ImageLR'], $width, $height, true);
		if($_GET['color'] != 0) $image['ImageLR'] = Base::get('ImageEditor')->colorImage($image['Filename'], $image['ImageLR'], $_GET['color']);
		
		header("Content-type: image/jpeg");
		header("Content-length: " .strlen($image['ImageLR']));
		header("Content-Disposition: attachment; filename=". $image['Filename']);
		echo $image['ImageLR'];
	}
	// echo $image['Content'];
	// dump($image);
?>