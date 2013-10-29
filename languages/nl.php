<?php
	function fLang($val){
		if($val == 'applicationname') return 'FotoSoftware';
		else if($val == 'pagenotfound') return 'Deze pagina kon helaas niet worden gevonden';
		else if($val == 'username') return 'Gebruikersnaam';
		else if($val == 'password') return 'Wachtwoord';
		else if($val == 'login') return 'Inloggen';
		else if($val == 'logout') return 'Uitloggen';
		else if($val == 'wronguserpass') return 'Uw gebruikersnaam en/of wachtwoord klopt niet';
		else if($val == 'welcome') return 'Welkom';
		else if($val == 'catalog') return 'Catalogus';
		else if($val == 'shoppingcart') return 'Winkelmandje';
		else if($val == 'editimage') return 'Afbeelding bewerken';
		else if($val == 'original') return 'Origineel';
		else if($val == 'blackwhite') return 'Zwart wit';
		else if($val == 'sepia') return 'Sepia';
		else if($val == 'printcolor') return 'Kleur';
		else if($val == 'zoom') return 'Zoom';
		else if($val == 'save') return 'Opslaan';
		else return 'Language error @ ' .$val;
	}
?>