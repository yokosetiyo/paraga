<?php defined('BASEPATH') or exit('No direct script access allowed');

class Auth extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Auth_model', 'auth');
    }

    public function index()
    {
        $this->login();
    }

    public function login()
    {
        if (!empty($this->session->userdata('USER_SESSION')['USER_ID'])) {
            if (!empty($this->session->userdata('USER_SESSION')['ROLE_ID'])) {
                redirect('app/v1');
            } else {
                redirect('role/auth/chooseRole/' . $this->session->userdata('USER_SESSION')['USER_ID']);
            }
        }

        $this->load->view('auth/login', [
            'csrf' => [
                'token_name'    => $this->security->get_csrf_token_name(),
                'hash'          => $this->security->get_csrf_hash(),
            ]
        ]);
    }

    public function process()
    {
        $username         = $this->input->post('username_user');
        $password         = $this->input->post('password_user');
        $url_redirect     = $this->input->post('url_redirect');

        $process = $this->auth->validate($username, $password);

        if (!empty($url_redirect)) {
            $process['data']->url_redirect_single_role     = $url_redirect;
            $process['data']->url_redirect                 = "?redirect={$url_redirect}";
        } else {
            $process['data']->url_redirect = "";
        }

        $this->changeSession($process);
    }

    public function changeSession($data)
    {
        $person = $data['data'];

        $session_data = array(
            'USER_ID'       => encode_id($person->id_user),
            'USER_NAME'     => strtoupper($person->username_user),
            'USER_FULLNAME' => $person->nama_user
        );

        // USER ROLE
        $role_check = $this->auth->checkrole($person->id_user);

        $role_count = (int) $role_check->num_rows();

        if ($role_count > 0) {
            if ($role_count == 1) {
                $role_data = $role_check->row();

                $session_data['ROLE_ID']    = encode_id($role_data->id_role);
                $session_data['ROLE_NAME']  = $role_data->nama_role;
                $session_data['MULTIROLE']  = false;

                $this->session->set_userdata('USER_SESSION', $session_data);
                $this->load_menu($role_data->id_role);

                if (!empty($person->url_redirect_single_role)) {
                    redirect($person->url_redirect_single_role);
                }

                redirect('app/v1');
            } else {
                $session_data['MULTIROLE'] = true;
                $this->session->set_userdata('USER_SESSION', $session_data);
                redirect(
                    'role/auth/chooseRole/' .
                        encode_id($person->id_user) .
                        $person->url_redirect
                );
            }
        } else {
            $this->session->set_flashdata('error_messages', 'Anggota "<b>' . $person->nama_user . '</b>" tidak memiliki hak akses di dalam aplikasi.');
            redirect(base_url('role/auth/login'), 'refresh');
        }
    }

    public function chooseRole($user_id)
    {
        $user_id = decode_id($user_id);

        if (empty($this->session->userdata('USER_SESSION')['USER_ID'])) {
            $this->session->set_flashdata('error_messages', 'Anda belum login!');
            redirect(base_url('role/auth/login'), 'refresh');
        }

        $user_data = $this->db->select('id_user')->where('id_user', $user_id)->get('users')->row();

        $this->db->select('user_role.*, ref_role.nama_role');
        $this->db->from('user_role');
        $this->db->join('ref_role', 'user_role.id_role = ref_role.id', 'left');
        $this->db->where([
            'user_role.id_user' => $user_id,
            'user_role.is_active' => '1',
            'ref_role.is_active' => '1'
        ]);

        $roles = $this->db->get()->result();

        $this->load->view('auth/roleChange', [
            'user_data' => $user_data,
            'roles' => $roles,
        ]);
    }

    public function choose()
    {
        $role_id         = decode_id($this->input->post('role_id'));
        $user_id         = decode_id($this->input->post('user_id'));
        $url_redirect    = $this->input->post('url_redirect');

        if (!empty($this->session->userdata('USER_SESSION')['ROLE_ID'])) {
            $session_data = $this->session->userdata('USER_SESSION');
            $session_data['ROLE_ID'] = null;
            $this->session->set_userdata('USER_SESSION', $session_data);
        }

        if ($user_id != decode_id($this->session->userdata('USER_SESSION')['USER_ID'])) {
            $this->session->set_flashdata('error_messages', 'Id pengguna tidak sesuai dengan yang dimasukkan.');
            redirect(base_url('role/auth/login'), 'refresh');
        }

        if (empty($role_id)) $this->chooseRole(encode_id($user_id));

        $role_data = $this->db->where('id', $role_id)->where('is_active','1')->get('ref_role')->row();

        $session_data = $this->session->userdata('USER_SESSION');
        $session_data['ROLE_ID']    = encode_id($role_id);
        $session_data['ROLE_NAME']  = $role_data->nama_role;
        $session_data['MULTIROLE']  = true;

        $this->session->set_userdata('USER_SESSION', $session_data);
        $this->load_menu($role_id);

        if (!empty($url_redirect)) {
            redirect($url_redirect);
        } else {
            redirect('app/v1');
        }
    }

    public function load_menu($role_id)
    {
        $session_menu   = [];
        $data_menu      = $this->auth->getMenu($role_id);
        foreach ($data_menu as $val) {
            if ($val->level == 1) {
                $session_menu['menu'][$val->level][] = $val;
            } else if ($val->level == 2) {
                $session_menu['menu'][$val->level][$val->id_parent][] = $val;
            } else {
                $session_menu['menu'][$val->level][$val->id_parent][] = $val;
            }
        }
        $this->session->set_userdata($session_menu);
    }

    public function change_password()
    {
        $data["callback"] = $this->input->get("callback");
        $this->load->view('auth/change_password', $data);
    }

    public function change_password_post()
    {
        $username           = get_user_session_value("USER_NAME");
        $password_old       = $this->input->post('pass_old', true);
        $password_new       = $this->input->post('password', true);
        $re_password_new    = $this->input->post('re_pass', true);

        try {
            $this->db->trans_begin();

            // jika username & password berbeda return
            $QUser = $this->db->where('username_user', $username)
                ->where('password_user', encrypt_pass_format($password_old))
                ->get('users')->row();

            // Jika password lama kosong return 
            if (empty($QUser)) {
                throw new Exception("Password lama tidak sesuai");
            }

            // Jika password baru kosong return 
            if (empty($password_new)) {
                throw new Exception("Password baru masih kosong");
            }

            // cek karakter di password
            $validateString = preg_match("/^(?=[A-Za-z0-9@\'^£$%&!*()}{@#~?><>,|=_+¬-]+$)^(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.*[@\'^£$%&!*()}{@#~?><>,|=_+¬-])(?=.{8,}).*$/", $password_new);

            // if (!$validateString) {
            //     throw new Exception("password harus lebih dari 8 karakter, mengandung spesial karakter, huruf BESAR, huruf kecil dan angka");
            // }

            // Jika re-password baru kosong return 
            if (empty($re_password_new)) {
                throw new Exception("Re-password baru masih kosong");
            }

            // Jika password dan password konfirmasi berbeda return 
            if ($password_new != $re_password_new) {
                throw new Exception("Password baru tidak sama");
            }

            // Jika user sudah ada di database lakukan update password
            $encode_password_new = encrypt_pass_format($password_new);
            $id = $QUser->id_user;

            $this->db->where('id_user', $id)
                ->set('password_user', $encode_password_new)
                ->set("updated_pass_at", date('Y-m-d H:i:s'))
                ->set("updated_pass_by", get_user_session_value("USER_FULLNAME"))
                ->update('users');

            $this->db->trans_commit();

            echo json_encode([
                "status"    => true,
                "data"      => [],
                "message"   => "Password berhasil diganti, silahkan login kembali dengan password yang baru"
            ], 200);
        } catch (Exception $ex) {
            $this->db->trans_rollback();

            echo json_encode([
                "status"    => false,
                "data"      => [],
                "message"   => strip_tags($ex->getMessage())
            ], $ex->getCode() ?? 200);
        }
    }

    public function logout($teks = null)
    {
        $this->session->sess_destroy();
        if (@$teks) {
            redirect('role/auth/login/' . $teks);
        } else {
            redirect('role/auth/login');
        }
    }
}