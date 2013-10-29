<?php
	//Type
	//0 = Not logged in
	//1 = Customer
	//2 = Admin

	class Login{
		private $queries;

		function Login(){
			$this->queries = Base::get('Queries', array('users'), true);
		}

		function userLogin($username, $password){
			$_SESSION['FontysPSE']['Login'] = array();

			$queryOptions = array('Fields' => array(), 'Where' => array());
			$queryOptions['Fields'] = array('CustomerID','FirstName','Name','Role');
			//Where
			$queryOptions['Where']['Username'] = Base::get('Encryption')->Encrypt($username, 'username');
			$queryOptions['Where']['Password'] = Base::get('Encryption')->Encrypt($password, 'password');
			//Excecute
			$result = $this->queries->get(null, $queryOptions);
			if(count($result) == 1){
				$_SESSION['FontysPSE']['Login']['ID'] = $result[0]['ID'];
				$_SESSION['FontysPSE']['Login']['Valid'] = true;
				$_SESSION['FontysPSE']['Login']['FirstName'] = $result[0]['FirstName'];
				$_SESSION['FontysPSE']['Login']['Name'] = $result[0]['Name'];
				$_SESSION['FontysPSE']['Login']['UserType'] = $result[0]['Role'];
				return true;
			}
			return false;
		}

		function userLogout(){
			$_SESSION['FontysPSE']['Login'] = array();
		}

		function isLoggedIn(){
			if(isset($_SESSION['FontysPSE']['Login']['Valid']) && $_SESSION['FontysPSE']['Login']['Valid']) return true;
			return false;
		}
	}
?>