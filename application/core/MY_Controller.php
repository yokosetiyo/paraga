<?php
defined('BASEPATH') or exit('No direct script access allowed');

class MY_Controller extends CI_Controller
{
    var $current_id, $token_password;
    public function __construct()
    {
        parent::__construct();
        if (!empty($this->session->userdata('USER_SESSION'))) {
            $this->current_id = decode_id($this->session->userdata('USER_SESSION')['USER_ID']);
            if (!empty($this->session->userdata('USER_SESSION')['ROLE_ID'])) {
                $this->role_id = decode_id($this->session->userdata('USER_SESSION')['ROLE_ID']);
            }

            $this->aksi = [
                'lihat'     => false,
                'tambah'    => false,
                'ubah'      => false,
                'hapus'     => false
            ];
        }
        if ($this->router->fetch_class() != 'auth') {
            if (empty($this->session->userdata('USER_SESSION')['USER_ID'])) {
                redirect('role/auth/login?redirect=' . urlencode(current_url()), 'refresh');
            }
        }
    }

    public function getMenuId()
    {
        $a = $this->uri->segment('1');
		$b = $this->uri->segment('2');
		$c = $this->uri->segment('3');
		$uri = $a.'/'.$b.'/'.$c;
		$menu = $this->db->where('link',$uri)->get('mst_menu')->row();
        return encode_id($menu->id);
    }

    public function checkPermission()
    {
        $menu_id = decode_id($this->getMenuId());
        $menu_role = $this->db->select('id_menu, GROUP_CONCAT(id_action) AS id_action')->where('id_role',$this->role_id)->group_by('id_menu')->get('menu_role')->result_array();
        $arr_menu = [];

        foreach($menu_role as $row) {
            $arr_menu[] = $row['id_menu'];
        }
        if (in_array($menu_id, $arr_menu)) {
            if ($this->checkAccess($this->getMenuId(),'1')) $this->aksi['lihat'] = true;

            if ($this->checkAccess($this->getMenuId(),'2')) $this->aksi['tambah'] = true;

            if ($this->checkAccess($this->getMenuId(),'3')) $this->aksi['ubah'] = true;
            
            if ($this->checkAccess($this->getMenuId(),'4')) $this->aksi['hapus'] = true;
            return true;
        } else {
            redirect('app/v1/error_page/access_denied');
        }
    }
    
    public function _auth()
    {
        if ($this->router->fetch_class() != 'auth') {
            if (empty($this->session->userdata('USER_SESSION')['USER_ID'])) {
                redirect('role/auth/login?redirect=' . urlencode(current_url()), 'refresh');
            }
        }
    }

    public function generatePassword($string)
    {
        $pwd_peppered = hash_hmac("sha256", $string, $this->token_password);
        $pwd_hashed = password_hash($pwd_peppered, PASSWORD_DEFAULT);

        return $pwd_hashed;
    }

    public function _not_found()
    {
        $menu = $this->db->where('name', 'beranda')->get('menus')->row();
        $beranda = site_url('auth/login');
        if ($this->session->userdata('logged_in') == true) {
            $beranda = site_url($menu->route . '/' . encode_id($menu->id));
        }
        $this->load->view('_layouts/_404', ['beranda' => $beranda]);
    }

    public function checkAccess($encrypted_menu_id = null, $action_id = null)
    {
        if (empty($encrypted_menu_id) || empty($action_id)) return false;

        $menu_id = decode_id($encrypted_menu_id);

        $access = $this->_checkRBAC($menu_id, $action_id);

        if ($access) return true;

        return false;
    }

    public function checkPermission_($encrypted_menu_id = null, $action_id = null)
    {
        if (empty($encrypted_menu_id) || empty($action_id)) return false;

        $menu_id = decode_id($encrypted_menu_id);

        $access = $this->_checkRBAC($menu_id, $action_id);

        if ($access) return true;

        redirect('error_page/access_denied');
    }

    public function checkAccessAjax($encrypted_menu_id = null, $action_id = null)
    {
        if (empty($encrypted_menu_id) || empty($action_id)) $this->_set_no_access();

        $menu_id = decode_id($encrypted_menu_id);

        $access = $this->_checkRBAC($menu_id, $action_id);

        if ($access) return true;

        $this->_set_no_access();
    }

    private function _checkRBAC($menu_id, $action_id)
    {
        $this->db->where([
            'is_active' => '1',
            'id_menu'   => $menu_id,
            'id_action' => $action_id,
            'id_role'   => $this->role_id,
        ]);

        $this->db->from('menu_role');

        $access = $this->db->get();

        if ($access->num_rows() == 0) return false;

        return true;
    }

    public function _set_success($data)
    {
        return $this->output
            ->set_content_type('application/json', 'utf-8')
            ->set_status_header(200)
            ->set_output(json_encode($data));
    }

    public function _set_failed($data)
    {
        return $this->output
            ->set_content_type('application/json', 'utf-8')
            ->set_status_header(400)
            ->set_output(json_encode($data));
    }

    public function _set_no_access()
    {
        return $this->output
            ->set_content_type('application/json', 'utf-8')
            ->set_status_header(403)
            ->set_output('forbidden');
    }

    public function _display($data, $view = null, $js = null)
    {
        $content_data = $this->getContentJsView($data, $view, $js);

        $this->load->view('_layouts/_base_layout', $content_data);
    }

    private function getContentJsView($data, $view, $js)
    {
        $view_path = '_contents/';

        if (array_key_exists('menu_id', $data)) {
            $data['access'] = [
                'tambah' => $this->checkAccess($data['menu_id'], 2),
                'edit' => $this->checkAccess($data['menu_id'], 3),
                'delete' => $this->checkAccess($data['menu_id'], 4),
            ];
        }
        
        $modal = [];
        if (array_key_exists('modal', $data)) {
            foreach ($data['modal'] as $value) {
                $modal[] = $this->load->view($view_path.$value, $data, true);
            }
        }

        if ($view == null) {
            $content = null;
        } else {
            $content = $this->load->view($view_path . $view, $data, true);
        }

        if ($js == null && $content != null) {
            $js = $view . '_js';
        } else {
            $js = null;
        }

        if ($js != null && file_exists(APPPATH . 'views/' . $view_path . $js . '.php')) {
            $javascript = $this->load->view($view_path.$js, $data, true);
        } else {
            $javascript = null;
        } 

        $return_data = [
            'content' => $content,
            'javascript' => $javascript,
            'modal' => $modal
        ];
        $array = array_merge($data, $return_data);

        return $array;
    }

    public function random_color_part()
    {
        return str_pad(dechex(mt_rand(0, 255)), 2, '0', STR_PAD_LEFT);
    }

    public function random_color()
    {
        return $this->random_color_part() . $this->random_color_part() . $this->random_color_part();
    }
}

/* End of file MY_Controller.php */