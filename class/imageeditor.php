<?php
	class ImageEditor{
		public function ImageEditor(){
		
		}

		public function colorImage($fileName, $fileContent, $color){
			$ext = explode('.', $fileName);
			$ext = strtolower($ext[count($ext)-1]);
			//Check for valid extension
			if($ext == 'png' || $ext == 'jpg' || $ext == 'jpeg' || $ext == 'gif' || $ext == 'bmp') $image = imagecreatefromstring($fileContent);
			else return $fileContent;
			if($color == 1) imagefilter($image, IMG_FILTER_GRAYSCALE);
			else if($color == 2){
				imagefilter($image,IMG_FILTER_GRAYSCALE);
				imagefilter($image,IMG_FILTER_BRIGHTNESS,-30);
				imagefilter($image,IMG_FILTER_COLORIZE, 90, 55, 30);
			}
			else return $fileContent;
			ob_start();
			if($ext == 'png') imagepng($image);
			else if($ext == 'jpg' || $ext == 'jpeg') imagepng($image);
			else if($ext == 'gif') imagegif($image);
			else if($ext == 'bmp') imagejpeg($image);
			$imageContent = ob_get_contents();
			ob_end_clean();
			return $imageContent;
			
		}
		public function resizeImage($fileName, $fileContent, $newWidth, $newHeight = 0, $resizeMax = true, $sizeOnly = false){
			$ext = explode('.', $fileName);
			$ext = strtolower($ext[count($ext)-1]);
			//Check for valid extension
			if($ext == 'png' || $ext == 'jpg' || $ext == 'jpeg' || $ext == 'gif' || $ext == 'bmp') $image = imagecreatefromstring($fileContent);
			else return $fileContent;
			//Get image size
			$curX = imagesx($image);
			$curY = imagesy($image);
			if($curX < $newWidth && $newHeight == 0) return $fileContent;
			// else if($curX < $newWidth && $curY < $newHeight) return $fileContent;
			//Resize to maximum from 1 of the paramaters (smaller)
			if($resizeMax){
				//Calculate from height
				if($newWidth == 0 || ($newWidth / $curX >= $newHeight / $curY && $newHeight != 0)){
					$ratio = $newHeight/$curY;
					$newX = round($curX * $ratio);
					$newY = round($curY * $ratio);
				}
				//Calculate from width
				else{
					$ratio = $newWidth/$curX;
					$newX = round($curX * $ratio);
					$newY = round($curY * $ratio);
				}
			}
			//Resize to minimum from 1 of the paramaters (bigger)
			else{
				//Calculate from height
				if($newWidth == 0 || $newWidth / $curX <= $newHeight / $curY){
					$ratio = $newHeight/$curY;
					$newX = round($curX * $ratio);
					$newY = round($curY * $ratio);
				}
				//Calculate from width
				else{
					$ratio = $newWidth/$curX;
					$newX = round($curX * $ratio);
					$newY = round($curY * $ratio);
				}
			}
			if($sizeOnly){
				return array('Width' => $newX, 'Height' => $newY);
			}
			//Create new image
			$newImg = imagecreatetruecolor($newX, $newY);
			imagealphablending($newImg, false);
			imagesavealpha($newImg,true);
			$transparent = imagecolorallocatealpha($newImg, 255, 255, 255, 127);
			imagefilledrectangle($newImg, 0, 0, $newX, $newY, $transparent);
			imagecopyresampled($newImg, $image, 0, 0, 0, 0, $newX, $newY, $curX, $curY);
			ob_start();
			if($ext == 'png') imagepng($newImg);
			else if($ext == 'jpg' || $ext == 'jpeg') imagepng($newImg);
			else if($ext == 'gif') imagegif($newImg);
			else if($ext == 'bmp') imagejpeg($newImg);
			$imageContent = ob_get_contents();
			ob_end_clean();
			return $imageContent;
		}
	}
?>