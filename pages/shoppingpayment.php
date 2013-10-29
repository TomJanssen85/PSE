<?php
	//Input from previous page (will be variable in future)
	$_SESSION['Chart']['Products'] = array(
		//Photo on product
		array('ImageID' => 1, 'ProductID' => 1, 'Amount' => 1, 'Height' => 600, 'Width' => 600, 'Position' => array(
			'Start' => array('X' => 5, 'Y' => 7), 'End' => array('X' => 500, 'Y' => 400)
		)),
		//Photo only
		array('ImageID' => 2, 'ProductID' => 0, 'Amount' => 1, 'Height' => 600, 'Width' => 600, 'Position' => array(
			'Start' => array('X' => 0, 'Y' => 0), 'End' => array('X' => 0, 'Y' => 0)
		))
	);
	//Sample for a dump for an array (equals to <pre>print_r(array)</pre>)
	dump($_SESSION['Chart']);

	//Check usertype for permission
	//Usertype: 0= not logged in, 1 = Customer, 2 = Photographer (Hard coded set as 1, will be variable in future)
	/** @var PageManager $pageManager */
	if($pageManager->getUserType() != 1) $pageManager->redirect('menu');

	//Page content

?>