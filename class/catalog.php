<?php
	//Type
	//0 = Not logged in
	//1 = Customer
	//2 = Admin

	class Catalog{
		private $queries;

		function Catalog(){
			$this->queries = Base::get('Queries', array('images'), true); 
		}
		
		function GetUserPhotos($customerId){

			$queryOptions = array('Fields' => array(), 'Where' => array(), 'LeftJoin' => array());
			
			// Fields
			$queryOptions['Fields'] = array('imagelink.Albumname', 'imagelink.CustomerID', 'images.ImageID', 'images.Filename', 'images.Name', 'images.Description', 'images.Price');
			
			//Join:
			$queryOptions['LeftJoin'] = array('imagelink' => array('imagelink.ImageID', 'images.ImageID'));
			//Field as other field name
			//$queryOptions['Fields']['ID'] = array('AS' => 'PictureID');
			
			
			//Where
			$queryOptions['Where']['imagelink.CustomerID'] = $customerId;
			//Excecute
			$results = $this->queries->get(null, $queryOptions);
			return $results;
		}
		
		function CreatePhoto($result){
		
			$html  = '<div class="SessionImage">';
			$html .= '	<img class="SessionImage" src="get/image.php?id=' .$result['ImageID']. '" />';
			$html .= '	<span class="SessionImageTitle" >'. $result['Name'] .'</span>';
			$html .= '	<span class="SessionImageDescription" >'. $result['Name'] .'</span>';
			$html .= '	<span class="SessionImageOrder" ><input type="text" name="amount" /><img src="http://www.jadoodirect.com/images/cart%20add%20Icon.jpg" onclick="" /></span>';
			$html .= '</div>';			
			
			return $html;
		}
		
		
		function CreateAlbum($images, $albumname){
		
			$html  = '<div class="SessionWrapper">';
			$html .= '	<div class="SessionTitle" onclick="$(this).parent().find(\'div.SessionImagesWrapper\').toggle();">'.$albumname .'</div>';
			$html .= '	<div class="SessionImagesWrapper">';
			$html .= '		'. $images;
			$html .= '	</div>';
			$html .= '	<div class="clear" > </div>';
			$html .= '</div>';
			
			return $html;
		}
		
		function RenderUserPhotos($results){
		
			$html = "";
			$images = "";
			
			$Prevalbum = $results[0]['Albumname'];
			foreach ($results as &$result) {
				
				if ($Prevalbum == $result['Albumname'])
				{
					// same album
					$images .= Base::get('Catalog')->CreatePhoto($result);
				}
				else
				{
					// different album
					$html .= Base::get('Catalog')->CreateAlbum($images, $Prevalbum);
					
					// Clear images
					$images = "";
					
					$images .= Base::get('Catalog')->CreatePhoto($result);
				}
				
				$Prevalbum = $result['Albumname'];
			}
			
			$html .= Base::get('Catalog')->CreateAlbum($images, $Prevalbum);
		
			return $html;
		}
	}
?>