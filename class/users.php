<?php
	//Type
		//1 = Customer
		//2 = Photographer

	class Users{
		private $queries;

		function Users(){
			$this->queries = Base::get('Queries', array('customers'), true);
		}
	}
?>