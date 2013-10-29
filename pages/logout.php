<?php
	Base::get('Login')->userLogout();
	Base::get('PageManager')->redirect('login');