<?php defined('BASEPATH') or exit('No direct script access allowed');

class Menu_model extends CI_Model
{
    var $table = 'mst_menu';
    var $primary = 'id';

    public function __construct()
    {
        parent::__construct();
    }

    public function getMenu()
    {
        $this->db->select('*');
        $this->db->from($this->table);
        $this->db->where([
            'is_active' => '1',
        ]);
        $this->db->order_by('level', 'ASC');
        $this->db->order_by('urutan', 'ASC');
        $query = $this->db->get();
        return $query->result();
    }

    public function getMenuId($id)
    {
        $query = $this->db->where($this->primary, $id)->get($this->table);
        return $query->row();
    }

    public function getParent($level)
    {
        $this->db->where('is_active', '1');
        $this->db->where('level', $level-1);
        $query = $this->db->get('mst_menu')->result();
        return $query;
    }

    public function getIcons()
    {
        $this->db->from('icons');
        $data = $this->db->get();

        return $data->result();
    }

    public function insertMenu($data)
    {
        $this->db->insert($this->table, $data);
    }
    
    public function updateMenu($data, $id)
    {
        $this->db->where($this->primary, $id)->update($this->table, $data);
    }

    public function deleteMenu($id)
    {
        $this->db->where($this->primary, $id)->update($this->table, ['is_active' => '0']);
    }
}