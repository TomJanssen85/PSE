<?php
	class QueryManager{
		private $table = '';

		public function QueryManager($table){
			$this->table = $table;
		}

		public function add($type, $queryExtra = array()){
			$query = array('Fields' => '', 'Values' => '', 'Parameters' => array(), 'ParamI' => 1);
			//Prepare
			$query['Fields'] = "`Type`";
			$query['Values'] = ":type";
			$query['Parameters'][':type'] = $type;
			//Query Extra
			if(isset($queryExtra['Fields'])){
				foreach($queryExtra['Fields'] as $field => $value){
					$query['Fields'] .= ",`" .$field. "`";
					$query['Values'] .= ",:defparam" .$query['ParamI'];
					$query['Parameters'][':defparam' .$query['ParamI']] = $value;
					$query['ParamI']++;
				}
			}
			//Insert
			$id = Base::get('Database')->Insert("INSERT INTO `" .$this->table. "` (" .$query['Fields']. ") VALUES (" .$query['Values']. ")",
				$query['Parameters']);
			//Return
			if($id !== false) return $id;
			return 0;
		}

		function edit($id, $type, $updateFields = array()){
			if(!isset($updateFields['Encrypted'])) $updateFields['Encrypted'] = $this->encryptedFields;
			$query = array('Update' => '', 'Where' => '', 'Parameters' => array(), 'ParamI' => 1);
			//Update fields
			foreach($updateFields['Fields'] as $field => $value){
				if(isset($updateFields['Encrypted'][$field])){
					$value = Base::get('Encryption')->Encrypt($value, $updateFields['Encrypted'][$field]);
				}
				$query['Update'] .= ",`" .$field. "` = :defparam" .$query['ParamI'];
				$query['Parameters'][':defparam' .$query['ParamI']] = $value;
				$query['ParamI']++;
			}
			//Update
			if($query['Update'] != ''){
				$query['Update'] = substr($query['Update'], 1);
				//Query where
				$query['Where'] .= "WHERE `ID` = :id AND `Type` = :type";
				$query['Parameters'][':id'] = $id;
				$query['Parameters'][':type'] = $type;
				//Excecute
				Base::get('Database')->Update("UPDATE `" .$this->table. "` SET " .$query['Update']. " " .$query['Where'], $query['Parameters']);
			}
		}

		function get($type, $options = null){
			if(!isset($options['Encrypted'])) $options['Encrypted'] = $this->encryptedFields;
			$query = array('Query' => '', 'Fields' => '', 'From' => '', 'Join' => '', 'Where' => '', 'Limit' => '', 'Order' => '',
				'Parameters' => array(), 'ParamI' => 1);
			if(isset($options['Parameters']) && is_array($options['Parameters']))
				$query['Parameters'] = array_merge($query['Parameters'], $options['Parameters']);
			//Fields
			$tempQuery = '';
			foreach($options['Fields'] as $field => $settings){
				if(!is_array($settings)) $field = $settings;
				$tempQuery .= "," .$this->field($field);
				if(is_array($settings) && isset($settings['AS'])){
					$tempQuery .= " AS " .$settings['AS'];
					if(isset($options['Encrypted'][$field])) $options['Encrypted'][$settings['AS']] = $options['Encrypted'][$field];
				}
			}
			$query['Fields'] .= substr($tempQuery, 1);
			//From
			$query['From'] .= $this->table;

			//Left join
			if(isset($options['LeftJoin']) && is_array($options['LeftJoin'])){
				foreach($options['LeftJoin'] as $table => $joins){
					$query['Join'] .= " LEFT JOIN `" .$table. "` ON " .$this->field($joins[0]). " = " .$this->field($joins[1]);
				}
			}
			//Where
			$tempQuery = '';
			if($type === null) $type = array();
			else if(!is_array($type)) $type = array($type);
			if(count($type) > 0){
				$i = 1;
				foreach($type as $t){
					$tempQuery .= " OR " .$this->field('Type'). " = :type" .$i;
					$query['Parameters'][':type' .$i] = $t;
					$i++;
				}
				if($tempQuery != '') $tempQuery = " AND (" .substr($tempQuery, 4). ")";
			}
			if(isset($options['Where']) && is_array($options['Where'])){
				foreach($options['Where'] as $field => $value){
					if(!is_array($value)) $value = array('Operator' => '=', 'Value' => $value);
					if(strstr($field, '#')){
						$field = explode('#', $field);
						$field = $field[0];
					}
					$tempQuery .= " AND " .$this->field($field). " " .$value['Operator']. " :defparam" .$query['ParamI'];
					$query['Parameters'][':defparam' .$query['ParamI']] = $value['Value'];
					$query['ParamI']++;
				}
			}
			if(isset($options['WhereOr'])){
				foreach($options['WhereOr'] as $orBatch){
					$tempQuery1 = "";
					foreach($orBatch as $field => $value){
						if(!is_array($value)) $value = array('Operator' => '=', 'Value' => $value);
						if(strstr($field, '#')){
							$field = explode('#', $field);
							$field = $field[0];
						}
						$tempQuery1 .= " OR " .$this->field($field). " " .$value['Operator']. " :defparam" .$query['ParamI'];
						$query['Parameters'][':defparam' .$query['ParamI']] = $value['Value'];
						$query['ParamI']++;
					}
					if($tempQuery1 != '') $tempQuery .= " AND (" .substr($tempQuery1, 4). ")";
				}
			}
			if($tempQuery != '') $query['Where'] .= " WHERE " .substr($tempQuery, 4);

			if(isset($options['Limit'])){
				if(is_array($options['Limit'])){
					$query['Limit'] .= " LIMIT :defparam" .$query['ParamI']. " ,:defparam" .($query['ParamI'] + 1);
					$query['Parameters'][':defparam' .$query['ParamI']] = array($options['Limit'][0], PDO::PARAM_INT);
					$query['ParamI']++;
					$query['Parameters'][':defparam' .$query['ParamI']] = array($options['Limit'][1], PDO::PARAM_INT);
					$query['ParamI']++;
				}
			}

			//Order
			if(isset($options['Order']) && is_array($options['Order'])){
				$tempQuery = '';
				foreach($options['Order'] as $field => $order){
					if(is_numeric($field)) $tempQuery .= "," .$this->field($order);
					else $tempQuery .= "," .$this->field($field). " " .$order;
				}
				if($tempQuery != '') $query['Order'] .= " ORDER BY " .substr($tempQuery, 1);
			}

			//Count only
			if(isset($options['CountOnly']) && $options['CountOnly']){
				$query['Query'] = "SELECT COUNT(`ID`) AS `Amount` FROM `" .$query['From']. "` " .$query['Where'];
				$result = Base::get('Database')->Select($query['Query'], $query['Parameters']);
				return $result[0][0];
			}
			$query['Query'] = "SELECT " .$query['Fields']. " FROM `" .$query['From']. "` " .$query['Join']. " " .$query['Where']. " " .$query['Limit']. " " .$query['Order'];
			$result = Base::get('Database')->Select($query['Query'], $query['Parameters']);
			$returnArray = array();
			if(is_array($result)){
				foreach($result as $rs){
					$tempArray = array();
					foreach($rs as $field => $value){
						if(!is_numeric($field)){
							if(isset($options['Encrypted'][$field])){
								$value = Base::get('Encryption')->Decrypt($value, $options['Encrypted'][$field]);
							}
							$tempArray[$field] = $value;
						}
					}
					$returnArray[] = $tempArray;
				}
			}
			else{
				echo '<b>SQL error:</b><br />';
				echo Base::get('Database')->getErrorMessage(). '<br />';
				echo '<b>Query:</b><br />';
				echo $query['Query']. '<br />';
				echo '<b>Real query:</b><br />';
				echo Base::get('Database')->showQuery($query['Query'], $query['Parameters']). '<br />';
			}
			if(isset($options['Where']['ID']) && count($returnArray) > 0) return $returnArray[0];
			return $returnArray;
		}

		function delete($type, $id){
			echo 'Not implemented: QueryManager::delete'; exit;
		}

		private function field($field){
			$fieldAs = '';
			if(is_array($field)){
				foreach($field as $f => $as){
					$field = $f;
					$fieldAs = " AS `" .$as. "`";
				}
			}
			if(strstr($field, '.')){
				$ex = explode('.', $field);
				return "`" .$ex[0]. "`.`" .$ex[1]. "`" . $fieldAs;
			}
			else return "`" .$this->table. "`.`" .$field. "`" . $fieldAs;
		}
	}
?>