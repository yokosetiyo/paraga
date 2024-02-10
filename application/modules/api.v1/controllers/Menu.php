<?php defined('BASEPATH') or exit('No direct script access allowed');

class Menu extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Menu_model', 'menu');
    }

    public function menuData()
    {
        $output = [
            'data' => $this->menu->getMenu(),
        ];

        $this->_set_success($output);
    }

    public function getIcons()
    {
        $data['icons'] = $this->menu->getIcons();

        echo json_encode([
            'status' => 'success',
            'data' => $data,
        ]);
    }
    
    public function getMenuId()
    {
        $id = $this->input->post('id', true);
        $data['data_row'] = $this->menu->getMenuId($id);

        echo json_encode([
            'status' => 'success',
            'data' => $data,
        ]);
    }

    public function getParent()
    {
        $level  = $this->input->post('level', true);
        $data   = $this->menu->getParent($level);

        echo json_encode([
            'status' => 'success',
            'data' => $data,
        ]);
    }

    public function hapus()
    {
        $id = $this->input->post('id', true);
        $this->menu->deleteMenu($id);
    }

    public function do_simpan()
    {
        $id = $this->input->post('id', true);
        $data = [
            'urutan' 	=> $this->input->post('urutan', true),
            'level' 	=> $this->input->post('level', true),
            'id_parent' => $this->input->post('parent', true),
            'nama' 		=> $this->input->post('nama', true),
            'tipe_link' => $this->input->post('tipe_link', true),
            'link' 		=> $this->input->post('link', true),
            'icon' 		=> $this->input->post('icon', true)
        ];

        if($id){
            $data['updated_at'] = date('Y-m-d H:i:s');
            $this->menu->updateMenu($data, $id);
        }else{
            $data['created_at'] = date('Y-m-d H:i:s');
            $this->menu->insertMenu($data);
        }

        if($this->db->affected_rows() > 0){
            $this->session->set_flashdata('msg_success', 'Menu berhasil disimpan');
        }else{
            $this->session->set_flashdata('msg_error', 'Menu gagal disimpan');
        }
        
        redirect('app/v1/menu');
    }
}