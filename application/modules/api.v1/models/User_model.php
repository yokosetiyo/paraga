<?php defined('BASEPATH') or exit('No direct script access allowed');

class User_model extends CI_Model
{
    var $table = 'users';
    var $primary = 'id_user';

    public function __construct()
    {
        parent::__construct();
    }

    public function getData($param = array())
    {
        if (!empty($param["fields"])) {
            $this->db->select($param["fields"]);
        } else {
            $this->db->select("a.id_user, a.username_user, a.nama_user, GROUP_CONCAT(c.nama_role) AS role");
        }

        if (!empty($param["filter"])) {
            $this->db->where($param["filter"]);
        }

        if (!empty($param["sort"])) {
            $this->db->order_by($param["sort"][0], $param["sort"][1]);
        }

        $this->db->from($this->table . ' a');
        $this->db->join('user_role b', 'a.id_user = b.id_user', 'LEFT');
        $this->db->join('ref_role c', 'b.id_role = c.id AND c.is_active = "1"', 'LEFT');
        $this->db->group_by('a.id_user');
        $this->db->where([
            'a.is_active' => '1',
        ]);
        $query = $this->db->get();
        return $query->result();
    }

    public function getDataId($id)
    {
        $query = $this->db->where($this->primary, $id)->get($this->table);
        return $query->row();
    }

    public function getRolesId($id)
    {
        $query = $this->db->where($this->primary, $id)->get('user_role');
        return $query->result();
    }

    public function insertData($data)
    {
        $this->db->insert($this->table, $data);
    }

    public function updateData($data, $id)
    {
        return $this->db->where($this->primary, $id)
            ->update($this->table, $data);
    }

    public function deleteData($id)
    {
        $this->db->where($this->primary, $id)->update($this->table, [
            'deleted_at' => date('Y-m-d H:i:s'),
            'is_active' => '0'
        ]);
    }

    public function lastId()
    {
        return $this->db->order_by('id_user', 'DESC')->get($this->table)->row()->id_user;
    }

    public function cekUsername($username)
    {
        return $this->db->where('username_user', $username)->get($this->table)->row();
    }

    public function deleteUserRole($USER_ID)
    {
        $this->db->where($this->primary, $USER_ID)->delete('user_role');
    }

    public function insertUserRole($batch)
    {
        $this->db->insert_batch('user_role', $batch);
    }
}