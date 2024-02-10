<?php defined('BASEPATH') or exit('No direct script access allowed');

class Hak_akses_model extends CI_Model
{
    var $table = 'ref_role';
    var $primary = 'id';

    public function __construct()
    {
        parent::__construct();
    }

    public function getData()
    {
        $this->db->select('*');
        $this->db->from($this->table);
        $this->db->where([
            'is_active' => '1',
        ]);
        $query = $this->db->get();
        return $query->result();
    }

    public function getDataId($id)
    {
        $query = $this->db->where($this->primary, $id)->get($this->table);
        return $query->row();
    }

    public function insertData($data)
    {
        $this->db->insert($this->table, $data);
    }
    
    public function updateData($data, $id)
    {
        $this->db->where($this->primary, $id)->update($this->table, $data);
    }

    public function deleteData($id)
    {
        $this->db->where($this->primary, $id)->update($this->table, [
            'is_active'     => '0',
            'deleted_at'    => date('Y-m-d H:i:s')
        ]);
    }

    public function getActions()
    {
        $this->db->from('aksi');
        $this->db->order_by('urutan', 'ASC');
        $data = $this->db->get();

        return $data->result();
    }
    
    public function getMenuRole($ROLE_ID = null)
    {
		if (!empty($ROLE_ID)) {
			$this->db->where('id_role', $ROLE_ID);
		}
        
        $this->db->from('menu_role');
        $data = $this->db->get();

        return $data->result();
    }

    public function deleteMenuRole($ROLE_ID)
    {
        $this->db->where('id_role', $ROLE_ID)->delete('menu_role');
    }

    public function insertMenuRole($batch)
    {
        $this->db->insert_batch('menu_role', $batch);
    }
}