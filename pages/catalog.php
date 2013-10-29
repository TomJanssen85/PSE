<?php
	/** @var PageManager $pageManager */

	//Usertype: 0= not logged in, 1 = Customer, 2 = Photographer
	if($pageManager->getUserType() != 1) $pageManager->redirect('menu');

	//$_SESSION['FontysPSE']['Login']['ID']
	$results = Base::get('catalog')->GetUserPhotos(2);
	dump($results);
	
	$pageContent .= '<form name="addToCart" action="photo.php" method="post">';
	
	$pageContent .= $results[0]['Albumname'];
	
	//$pageContent .= Base::get('catalog')->RenderUserPhotos($results);
	
	//$pageContent .= dump($_SESSION['Cart']);
	if(sizeof($results) > 0){
	
		$pageContent .= Base::get('catalog')->RenderUserPhotos($results);
	
	}
	else{
		//$pageContent .= "No images found for this user";
	}
	
	
	//Page content
	//  //userid
	
	
	
?>

<style type="text/css">

	.SessionTitle {
		font-size: 20px;
		font-style: italic;
		cursor: pointer;
	}
	.SessionImagesWrapper {
		border: 1px solid black;
	}
	div.SessionImage {
		float: left;
		width: 200px;
		margin: 25px;
	}
	.SessionWrapper {
		clear: both;
		margin-bottom: 50px;
		margin: 25px;
	}
	img.SessionImage {
		width: 200px;
	}
	.SessionImageTitle {
		margin-left: auto;
		margin-right: auto;
	}
	.clear {
		clear: both;
	}

</style>



<?php
	/** @var PageManager $pageManager */
	/**	if($pageManager->getUserType() != 1) $pageManager->redirect('menu'); */

	//Page content
	//Get images
	/*  	
	$images = Base::get('Images')->get(1);
	foreach($images as $image){
		$pageContent .= '<div class="catalogitem">';
			$pageContent .= '<form method="post">';
			$pageContent .= '<img src="getimage.php?id=' .$image['ImageID']. '" /><br />';
			$pageContent .= '<input type="text" name="amount" /><br />';
			$pageContent .= '</form>';
		$pageContent .= '</div>';
	}  
	*/
	
	
	$pageContent .= '</form>';
?>