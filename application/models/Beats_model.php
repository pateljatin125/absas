<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Beats_model extends CI_Model
{

	function __Construct()
	{ 		 # create constructor 
		$this->load->database();		 # load the database
	}


	function cartDetails($vend_id)
	{

		$this->db->select('c.total_amount,c.amount,c.order_no,c.vendor_id,c.product_id,c.qty, p.product_name,p.product_price,p.product_desc,p.category_name,p.images');
		$this->db->from('addcart_product c');
		$this->db->join('product p', 'p.prod_id=c.product_id', 'inner');
		$this->db->where('vendor_id', $vend_id);
		$this->db->where('invoice_no', 0);
		$query = $this->db->get();
		return $query->result();
	}

	function favourite($vend_id)
	{
		$this->db->select('f.fev_id,p.prod_id,p.product_name,p.product_price,p.product_desc,p.category_name,p.images');
		$this->db->from('favorite f');
		$this->db->join('product p', 'p.prod_id=f.prod_id', 'inner');
		$this->db->where('ven_id', $vend_id);
		$query = $this->db->get();
		return $query->result();
	}

	# function for select data from database , with condition , limit , order , like and join clause
	function select_data($field, $table, $where = '', $limit = '', $order = '', $like = '', $join_array = '', $group = '', $clumname = '', $wherein = '')
	{
	   
		$this->db->select($field);
		$this->db->from($table);
		if ($where != "") {
			$this->db->where($where);
		}


		if ($wherein != "") {
			$this->db->where_in($table . '.' . $clumname['0'], $wherein);
		}
		// sturcture for multiple join
		//array('multiple' , array(array('TABLE NAME' , 'CONDITION'),array('TABLE NAME' , 'CONDITION')))

		if ($join_array != '') {
			if (in_array('multiple', $join_array)) {
				foreach ($join_array['1'] as $joinArray) {
					if (count($joinArray) == 3) {
						$this->db->join($joinArray[0], $joinArray[1], $joinArray[2]);
					} else {
						$this->db->join($joinArray[0], $joinArray[1]);
					}
				}
			} else {
				if (count($joinArray) == 3) {
					$this->db->join($join_array[0], $join_array[1], $join_array[2]);
				} else {
					$this->db->join($join_array[0], $join_array[1]);
				}
			}
		}

		if ($order != "") {
			if ($this->isAssoc($order)) {
				foreach ($order as $k => $or) {
					$this->db->order_by($k, $or);
				}
			} else {
				$this->db->order_by($order['0'], $order['1']);
			}
		}

		if ($group != "") {
			$this->db->group_by($group);
		}

		if ($limit != "") {
			if (count($limit) > 1) {
				$this->db->limit($limit['0'], $limit['1']);
			} else {
				$this->db->limit($limit);
			}
		}

		/*if($like != ''){
			$this->db->like($like);
		}*/
		if ($like != "") {
			$this->db->like($like[0], $like[1]);
		}
		return $this->db->get()->result_array();
		die();
	}
	function login_data($field, $table, $where = '', $limit = '', $order = '', $like = '', $join_array = '', $group = '', $clumname = '', $wherein = '')
	{
	    //echo "123";die;
		$this->db->select($field);
		$this->db->from($table);
		if ($where != "") {
			$this->db->where($where);
		}
			return $this->db->get()->result_array();
		die();
	}
	# function for insert data in database  
	function insert_data($table, $data)
	{
		$this->db->insert($table, $data);
		return $this->db->insert_id();
		die();
	}
	
	# function for get random toast message in Dashboard
    function select_toast_msg($tableName, $tableField, $fieldValue, $orderField) {
		$this->db->where($tableField, $fieldValue);
		$this->db->order_by($orderField, 'RANDOM');
		$this->db->limit(1);
		$this->db->select('*');
		return $this->db->get($tableName);
	}

	# function for delete data from database 
	function delete_data($table, $condition)
	{
		return $this->db->delete($table, $condition);
		die();
	}

	# function for update data in database 
	function update_data($table, $data, $condition)
	{
		$this->db->where($condition);
		return $this->db->update($table, $data);
		die();
	}

	# function for group by and count
	function groupby_count($field_name, $table, $group_clm, $limit)
	{
		$this->db->select($field_name);
		$this->db->from($table);
		if ($group_clm != '') {
			$this->db->group_by($group_clm);
		}
		if ($limit != "") {
			if (count($limit) > 1) {
				$this->db->limit($limit['0'], $limit['1']);
			} else {
				$this->db->limit($limit);
			}
		}

		return $this->db->get()->result_array();
		die();
	}


	# function for call the aggregate function like as 'SUM' , 'COUNT' etc 
	function aggregate_data($table, $field_nm, $function, $where = NULL, $join_array = NULL)
	{
		$this->db->select("$function($field_nm) AS MyFun");
		$this->db->from($table);
		if ($where != '') {
			$this->db->where($where);
		}

		if ($join_array != '') {
			if (in_array('multiple', $join_array)) {
				foreach ($join_array['1'] as $joinArray) {
					$this->db->join($joinArray[0], $joinArray[1]);
				}
			} else {
				$this->db->join($join_array[0], $join_array[1]);
			}
		}

		$query1 = $this->db->get();

		if ($query1->num_rows() > 0) {
			$res = $query1->row_array();
			return ($res['MyFun'] == '') ? 0 : $res['MyFun'];
		} else {
			return 0;
		}
		die();
	}

	function isAssoc(array $arr)
	{
		if (array() === $arr) return false;
		return array_keys($arr) !== range(0, count($arr) - 1);
	}
	
	public function record_count() 
	{
        return $this->db->count_all('iWitness');
    }
    
    public function select_all_template($tableName) {
		$this->db->where('PoliceUnitType_id >', 8);
		return $this->db->get($tableName);
	}
	
	// Search one parameter
	public function get_today_sos($searchField, $searchValue)
	{
		$this->db->select('*');
		$this->db->like($searchField, $searchValue);
		return $this->db->get('SOSManagement');
	}
}
