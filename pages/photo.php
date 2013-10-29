<?php
	/** @var PageManager $pageManager */

	//Usertype: 0= not logged in, 1 = Customer, 2 = Photographer
	if($pageManager->getUserType() != 1) $pageManager->redirect('menu');

	$_POST['imageid'] = 1;

	if(isset($_POST['imageid'])){
		$pageContent .= '<script type="text/javascript" src="js/photo.js"></script>';
		$pageContent .= '<script type="text/javascript">';
			$pageContent .= '$(document).ready(function(){';
				$pageContent .= 'prepareSampleImage();';
			$pageContent .= '});';
		$pageContent .= '</script>';
		$pageContent .= '<h1>' .fLang('editimage'). '</h1>';
		$pageContent .= '<span id="imageurl"></span>';
		$pageContent .= '<div id="sample-image"><img id="sample-image-image" /></div>';
		$pageContent .= '<div id="sample-image-options">';
			$pageContent .= '<form method="post">';
				$pageContent .= '<table>';
					$pageContent .= '<tr>';
						$pageContent .= '<td>' .fLang('printcolor'). ':</td><td class="marge"></td>';
						$pageContent .= '<td>';
							$pageContent .= '<select id="printcolor" name="printcolor" class="photochange">';	
								$pageContent .= '<option value="0">' .fLang('original'). '</option>';
								$pageContent .= '<option value="1">' .fLang('blackwhite'). '</option>';
								$pageContent .= '<option value="2">' .fLang('sepia'). '</option>';
							$pageContent .= '</select>';
						$pageContent .= '</td>';
					$pageContent .= '</tr>';
					$pageContent .= '<tr>';
						$pageContent .= '<td>' .fLang('zoom'). ':</td><td class="marge"></td>';
						$pageContent .= '<td>';
							$pageContent .= '<div id="image-zoom"></div>';
							$pageContent .= '<input type="hidden" name="image-zoom-value" id="image-zoom-value" />';
							$pageContent .= '<input type="hidden" name="image-left-value" id="image-left-value" />';
							$pageContent .= '<input type="hidden" name="image-top-value" id="image-top-value" />';
						$pageContent .= '</td>';
					$pageContent .= '</tr>';
					$pageContent .= '<tr>';
						$pageContent .= '<td></td><td class="marge"></td>';
						$pageContent .= '<td>';
							$pageContent .= '<br /><input type="submit" value="' .fLang('save'). '" />';
						$pageContent .= '</td>';
					$pageContent .= '</tr>';
				$pageContent .= '</table>';
			$pageContent .= '</form>';
		$pageContent .= '</div>';
		$pageContent .= '<input type="hidden" id="image-id" value="' .$_POST['imageid']. '" />';
	}
	else{
		$pageManager->redirect('catalog');
	}