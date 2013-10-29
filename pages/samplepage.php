<?php
	/** @var PageManager $pageManager */

	//Usertype: 0= not logged in, 1 = Customer, 2 = Photographer
	if($pageManager->getUserType() != 1) $pageManager->redirect('menu');

	//Page content

?>