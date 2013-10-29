<?php
	class Database{
		private $pdo;
		private $lastError;
		private $lastQuery = null;

		public function Database($connect = true){
			if($connect) $this->Connect();
		}

		public function Connect(){
			$this->pdo = new PDO('mysql:host=localhost;dbname=hedacom_fontys-pse', 'hedacom_fon-pse', 'Awa2TpP1');
			$this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		}

		private function Execute($query, $parameters = null){
			$sth = $this->pdo->prepare($query);
			foreach($parameters as $param => $value){
				if(is_array($value)){
					$sth->bindValue($param, $value[0], $value[1]);
				}
				else $sth->bindValue($param, $value);
			}
			$sth->execute();
			$this->lastQuery = array('Query' => $query, 'Parameters' => $parameters);
			return $sth;
		}

		public function Select($query, $parameters = null){
			try{
				$sth = $this->Execute($query, $parameters);
				return $sth->fetchAll();
			}
			catch(PDOException $ex){
				$this->lastError = $ex->getMessage();
				return false;
			}
		}

		public function Insert($query, $parameters = null){
			try{
				$sth = $this->Execute($query, $parameters);
				return $this->pdo->lastInsertId();
			}
			catch(PDOException $ex){
				$this->lastError = $ex->getMessage();
				return false;
			}
		}
		public function Update($query, $parameters = null){
			$sth = $this->pdo->prepare($query);
			$result = $sth->execute($parameters);
			return $result;
		}

		public function Delete($query, $parameters = null){
			$sth = $this->pdo->prepare($query);
			$result = $sth->execute($parameters);
			return $result;
		}

		public function showQuery($query, $parameters){
			dump($parameters);
			if(is_array($parameters)){
				foreach($parameters as $param => $value){
					$query = str_replace($param, "'" .$value. "'", $query);
				}
			}
			return $query;
		}

		public function showLastQuery($real = false){
			if($this->lastQuery === null) return '';
			if($real) return $this->lastQuery['Query'];
			else return $this->showQuery($this->lastQuery['Query'], $this->lastQuery['Parameters']);
		}

		public function getErrorMessage(){
			return $this->lastError;
		}
	}
?>