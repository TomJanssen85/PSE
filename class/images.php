<?php
	//Type
		// 1 = Default

	class Images{
		private $queries;

		public function Images(){
			$this->queries = Base::get('Queries', array('images'), true);
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
			$queryOptions = array('Fields' => array(), 'Where' => array());
			//Fields
			if(isset($options['ImageID'])){
				$queryOptions['Fields'] = array('ImageID', 'ImageLR', 'Filename');
				$queryOptions['Where']['ImageID'] = $options['ImageID'];
			}
			else{
				$queryOptions['Fields'] = array('ImageID');
			}
			//Where
			if($type != null) $queryOptions['Where']['ImageType'] = $type;
			//Excecute
			$result = $this->queries->get(null, $queryOptions);
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