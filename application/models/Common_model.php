<?php

class Common_model extends CI_Model
{
	function __construct()
	{
		parent::__construct();
	}

	function add($table, $data)
	{
		try {
			$this->db->insert($table, $data);
			if ($this->db->affected_rows() > 0) {
				return $this->db->insert_id();
			} else {
				throw new Exception("Gagal menambahkan data");
			}
		} catch (Exception $ex) {
			throw new Exception($ex);
		}
	}

	function exec_query($query_string)
	{
		$q = $this->db->query($query_string);

		if ($q->num_rows() > 0) {
			return  $q->result_array();
		} else {
			return false;
		}
	}

	function add_batch($table, $data)
	{
		$query = $this->db->insert_batch($table, $data);
		if ($this->db->affected_rows() > 0) {
			return $query;
		} else {
			throw new Exception("Gagal menambahkan data");
		}
	}

	function get_data($table, $param)
	{
		if (isset($param['fields']) && $param['fields'] != '') {
			$this->db->select($param['fields']);
		} else {
			$this->db->select("*");
		}

		$this->db->from($table);

		if (!empty($param['filter']))
			$this->db->where($param['filter']);

		if (!empty($param["sort"]))
			$this->db->order_by($param["sort"][0], $param["sort"][1]);

		if (!empty($param['group']))
			$this->db->group_by($param['group']);
		
		if (!empty($param['limit']))
			$this->db->limit($param['limit']);

		$query = $this->db->get();
		
		if ($query->num_rows() > 0) {
			$column   = $query->field_data();
            $data     = $query->result_array();
            $data     = cast_to_native_type($data, $column);

			return $data;
		} else {
			return [];
		}
	}

	function check_duplicate_data($table, $filter = array())
	{

		$this->db->select('*');

		if (isset($filter)) {
			$this->db->where($filter);
		}

		$query = $this->db->get($table);

		if ($query->num_rows() > 0) {
			return true;
		} else {
			return false;
		}
	}

	function update($table, $data, $param = array())
	{
		try {
			$this->db->where($param['filter']);
			$this->db->update($table, $data);

			return true;
		} catch (\Exception $ex) {
			return false;
		}
		
	}

	function force_delete($table, $param)
	{
		$this->db->where($param['filter']);
		$this->db->delete($table);
	}
}