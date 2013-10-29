<?php
	//Type
		// 1 = Default

	class ClassTemplate{
		private $queries;

		public function ClassTemplate(){
			echo 'Not implemented: ClassTemplate::ClassTemplate'; exit;
			$this->queries = Base::get('Queries', array('classtemplatetable'), true);
		}

		public function add($type){
			echo 'Not implemented: ClassTemplate::add'; exit;
			return $this->queries->add($type);
		}

		function edit($id, $type, $options = null){
			echo 'Not implemented: ClassTemplate::edit'; exit;
			$queryOptions = array();
			if(isset($options['Title']) && $options['Title'] !== null) $queryOptions['Fields']['Title'] = $options['Title'];
			//Excecute
			$this->queries->edit($id, $type, $queryOptions);
		}

		function get($type, $options = null){
			echo 'Not implemented: ClassTemplate::get'; exit;
			$queryOptions = array('Fields' => array(), 'Where' => array());
			//Fields
			if(isset($options['ID'])){
				$queryOptions['Fields'] = array('ID');
				$queryOptions['Where']['ID'] = $options['ID'];
			}
			else{
				$queryOptions['Fields'] = array('ID');
			}
			//Where
			$queryOptions['Where']['Deleted'] = '0';
			//Excecute
			$result = $this->queries->get($type, $queryOptions);
			return $result;
		}

		function delete($type, $id){
			echo 'Not implemented: ClassTemplate::delete'; exit;
			$this->queries->edit($id, $type, array('Fields' => array('Deleted' => 1)));
		}
	}
	
	//Examples
		//Join:
			//$queryOptions['LeftJoin'] = array('#table#' => array('#field1#', '#field1#'));
		//Field from other table
			//$queryOptions['Fields'] = array('#table#.#field#');
		//Field as other field name
			//$queryOptions['Fields']['ID'] = array('AS' => 'PictureID');
?>