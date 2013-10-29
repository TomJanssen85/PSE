<?php
	include_once('../base/base.php');
	/** @var PageManager $pageManager */
	$pageManager = Base::get('PageManager');

	echo Base::get('Encryption')->Encrypt('Tom', 'username');
	echo '<br />';
	echo Base::get('Encryption')->Encrypt('tj85', 'password');
?>