<?php
class Master extends MX_Controller 

{

  function __construct() {
	parent::__construct();
	$this->load->model('master_model');
  }

  
  function get($table){
	  $query = $this->master_model->get($table);
	  return $query;
  }
  
  function get_with_limit($table, $limit, $offset, $order_by) {
	  if ((!is_numeric($limit)) || (!is_numeric($offset))) {
		  die('Non-numeric variable!');
	  }
  
	  $query = $this->master_model->get_with_limit($table, $limit, $offset, $order_by);
	  return $query;
  }
  
  function get_where($table, $id){
	  if (!is_numeric($id)) {
		  die('Non-numeric variable!');
	  }
  
	  $query = $this->master_model->get_where($table, $id);
	  return $query;
  }
  
  function get_where_custom($table, $col, $value){
	  $query = $this->master_model->get_where_custom($table, $col, $value);
	  return $query;
  }
  
  function _insert($table, $data){
	  $this->master_model->_insert($table, $data);
  }
  
  function _update($table, $id, $data){
	  if (!is_numeric($id)) {
		  die('Non-numeric variable!');
	  }
  
	  $this->master_model->_update($table, $id, $data);
  }
  
  function _update_where_custom($table, $col, $value, $data){
	  
	  $this->master_model->_update_where_custom($table, $col, $value, $data);
  }
  
  function _delete($table, $id){
	  if (!is_numeric($id)) {
		  die('Non-numeric variable!');
	  }
  
	  $this->master_model->_delete($table, $id);
  }
  
  function count_where($table, $column, $value){
	  $count = $this->master_model->count_where($table, $column, $value);
	  return $count;
  }
  
  function get_max($table){
	  $max_id = $this->master_model->get_max($table);
	  return $max_id;
  }
  
  function _custom_query($mysql_query){
	  $query = $this->master_model->_custom_query($mysql_query);
	  return $query;
  }
  
  
  function _get_OA($table, $column, $study_id){
  
	  $query = $this->master_model->_get_OA($table, $column, $study_id);
	  return $query;
  }
  
  
  
  function delete_where_custom($table, $col, $value){
	  
	  $this->master_model->delete_where_custom($table, $col, $value);
  }
  
  
  
  
  function _dc_name($dc_id){
  	
	$query = $this->db->query("select * from db01t01_users where dc_id = $dc_id");
	if($query->num_rows() > 0){
		$row = $query->row();
		return $row->first_name." ".$row->last_name;
	} else{
		return "No Name";
	}
  }
  
  
  function _calculate_age($study_id){
  
	  $query = $this->master_model->_custom_query("select Q1607_1, Q1607_2, Q1607_3, Q1608_1, Q1608_2, Q1608_3 from q1101_q1610 where study_id = '".$study_id."'")->row();
	  $age = 0;
	  if($query->Q1607_1 > 0 || $query->Q1607_1 > 0 || $query->Q1607_1 > 0) {
	  	
		if($query->Q1607_1 > 0){
			
			$age = $query->Q1607_1;
			return $age." days";
			
		} else if($query->Q1607_2 > 0){
		
			$age = $query->Q1607_2;
			return $age." months";;
			
		} else if($query->Q1607_3 > 0){
		
			$age = $query->Q1607_3;
			return $age." years";;
		}
		
	  } else {
	  
	  	if($query->Q1608_1 > 0){
			
			$age = $query->Q1608_1;
			return $age." days";;
			
		} else if($query->Q1608_2 > 0){
		
			$age = $query->Q1608_2." months";;
			return $age;
			
		} else if($query->Q1608_3 > 0){
		
			$age = $query->Q1608_3;
			return $age." years";;
		}
	  }
	  
	  return $age." Days";
  }
  
  
  function _neonate_age($study_id){
  
	  $query = $this->master_model->_custom_query("select Q1607_1, Q1608_1, Q1610_1, Q1610_2, Q1610_3 from q1101_q1610 where study_id = '".$study_id."'")->row();
	  
	  $age = 0;
	  
	  if($query->Q1607_1 > 0) {
	  	
		$age = $query->Q1607_1;
		return $age." days";
		
	  } else if($query->Q1607_1 == 0 and $query->Q1608_1 > 0){
	  	
		$age = $query->Q1608_1;
		return $age." days";
		
	  } else if($query->Q1607_1 == 0 and $query->Q1608_1 == 0 and $query->Q1610_1 > 0){
	  	
		$age = $query->Q1610_1;
		return $age." days";
		
	  } else if($query->Q1607_1 == 0 and $query->Q1608_1 == 0 and $query->Q1610_1 == 0 and $query->Q1610_2 > 0){
	  	
		$age = $query->Q1610_2;
		return $age." hours";
		
	  } else if($query->Q1607_1 == 0 and $query->Q1608_1 == 0 and $query->Q1610_1 == 0 and $query->Q1610_2 == 0 and $query->Q1610_3 > 0){
	  	
		$age = $query->Q1610_3;
		return $age." minutes";
	  }
	  
	  return $age." Days";
  }
  
  
  	function _physician_name($id){
		
		$query = $this->master->_custom_query("select first_name, last_name from db01t01_users where id = $id")->row();
		
		return $query->first_name." ".$query->last_name;
	}
	
	
	function _reviewer_name($assignment_id){
		
		$query  = $this->master->_custom_query("select physician from db02t04_assignments where assignment_id = '$assignment_id'")->row();
		$query2 = $this->master->_custom_query("select first_name, last_name from db01t01_users where id = $query->physician")->row();
		
		return $query2->first_name." ".$query2->last_name;
		
		//return $this->_physician_name($query->physician);
	}
	
	
	
	function _get_physician($assignment_id){
		
		$query  = $this->master->_custom_query("select physician from db02t04_assignments where assignment_id = '$assignment_id'")->row();
		
		return $query->physician;
	}
	
	
	////// close db connection ////
	public function __destruct() {
		
		//$this->db = $this->load->database('nns_vasa', TRUE);
		$this->db->close();
	}
  
}