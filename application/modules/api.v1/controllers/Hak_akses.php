<?php defined('BASEPATH') or exit('No direct script access allowed');

class Hak_akses extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Hak_akses_model', 'hak_akses');
        $this->load->model('Menu_model', 'menu');
    }

    public function getData()
    {
        $output = [
            'data' => $this->hak_akses->getData(),
        ];

        $this->_set_success($output);
    }

    public function getHakAksesId()
    {
        $id = $this->input->post('id', true);

        $data['data_row'] = $this->hak_akses->getDataId($id);

        echo json_encode([
            'status' => 'success',
            'data' => $data,
        ]);
    }

    public function hapus()
    {
        $id = $this->input->post('id', true);
        $this->hak_akses->deleteData($id);
    }

    public function do_simpan()
    {
        $id = $this->input->post('id', true);
        $data = [
            'nama_role' => $this->input->post('name', true)
        ];

        if($id){
            $data['updated_at'] = date('Y-m-d H:i:s');
            $this->hak_akses->updateData($data, $id);
        }else{
            $data['created_at'] = date('Y-m-d H:i:s');
            $this->hak_akses->insertData($data);
        }

        if($this->db->affected_rows()>0){
            $this->session->set_flashdata('msg_success', 'Hak Akses berhasil disimpan');
        }else{
            $this->session->set_flashdata('msg_error', 'Hak Akses gagal disimpan');
        }
        
        redirect('app/v1/hak_akses');
    }

    public function getDataHakAkses()
    {
        $ROLE_ID = $this->input->post('ROLE_ID', true);
        $dt_menu_role = $this->hak_akses->getMenuRole($ROLE_ID);
        $menu_role = [];
        foreach ($dt_menu_role as $v) {
            $menu_role[$v->id_menu][$v->id_action] = $v->is_active;
        }
        $data['menu_role'] = $menu_role;
        $data['data_row'] = $this->hak_akses->getDataId($ROLE_ID);
        $data['menu'] = $this->menu->getMenu();
        $data['actions'] = $this->hak_akses->getActions();

        echo json_encode([
            'status' => 'success',
            'data' => $data,
        ]);
    }

    public function do_simpan_hak()
    {
        $ROLE_ID    = $this->input->post('role_id', true);
        $menu       = $this->menu->getMenu();
        $action     = $this->hak_akses->getActions();
        $batch      = [];
        foreach ($menu as $m) {
            foreach ($action as $a) {
                $cek = $this->input->post('check_'.$m->id.'_'.$a->id_aksi, true);
                if(!empty($cek)){
                    $batch[] = [
                        'id_role'       => $ROLE_ID,
                        'id_menu'       => $m->id,
                        'id_action'     => $a->id_aksi,
                        'is_active'     => '1',
                        'created_at'    => date('Y-m-d H:i:s')
                    ];
                }
            }
        }

        $this->hak_akses->deleteMenuRole($ROLE_ID);
        $this->hak_akses->insertMenuRole($batch);

        if($this->db->affected_rows() > 0){
            $this->session->set_flashdata('msg_success', 'Hak Akses berhasil disimpan');
        }else{
            $this->session->set_flashdata('msg_error', 'Hak Akses gagal disimpan');
        }
        
        redirect('app/v1/hak_akses');
        
    }

    public function refreshMenu()
    {
        $data_menu = $this->db->select('b.id, b.level, b.link, b.tipe_link, b.nama, b.icon, b.id_parent')
            ->where([
                'id_role'   => decode_id($this->session->userdata('role_id')),
                'id_action' => '1'
            ])
            ->join('mst_menu b', 'a.id_menu = b.id')
            ->order_by('b.urutan', 'ASC')
            ->get('menu_role a')->result();
        foreach($data_menu as $val){
            if($val->LEVEL == 1){
                $session_menu['menu'][$val->LEVEL][] = $val;
            }else if($val->LEVEL == 2){
                $session_menu['menu'][$val->LEVEL][$val->PARENT_ID][] = $val;
            }else {
                $session_menu['menu'][$val->LEVEL][$val->PARENT_ID][] = $val;
            }
        }
        $this->session->set_userdata($session_menu);
        redirect('app/v1/hak_akses');
    }
}