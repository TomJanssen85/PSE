<?php
	//@Tom, de andere pagina's kun je zelf aanmaken met dit template
	//Ik wist niet precies welke pagina je nodig hebt. Kijk even bij shoppingchart.php voor een voorbeeld voor inkomende parameters (sessie)

	//Input from previous page (will be variable in future)
		//Not needed for catalog

	//Sample for a dump for an array (equals to <pre>print_r(array)</pre>)
		//dump($array);

	//Check usertype for permission
	//Usertype: 0= not logged in, 1 = Customer, 2 = Photographer (tegenwoordig is deze variabel)
	/** @var PageManager $pageManager */
	if($pageManager->getUserType() != 2) $pageManager->redirect('menu');

	//Page content

?>