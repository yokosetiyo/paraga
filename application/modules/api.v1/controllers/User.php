<?php defined('BASEPATH') or exit('No direct script access allowed');

class User extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('User_model', 'user');
        $this->load->model('Hak_akses_model', 'hak_akses');
    }

    public function getData()
    {
        $output = [
            'data' => $this->user->getData(),
        ];

        $this->_set_success($output);
    }
    
    public function getHakAkses()
    {
        $output = [
            'data' => $this->hak_akses->getData(),
        ];

        $this->_set_success($output);
    }
       
	public function getDataId()
    {
        $id = $this->input->post('id', true);
        $output = [
            'roles' => $this->user->getRolesId($id),
            'data_row' => $this->user->getDataId($id),
        ];

        $this->_set_success($output);
    }

    public function hapus()
    {
        $id = $this->input->post('id', true);
        $this->user->deleteData($id);
    }

    public function do_simpan()
    {
        $id 			= $this->input->post('id', true);
		$username 		= $this->input->post('username', true);
        $password 		= $this->input->post('password', true);
        $re_password 	= $this->input->post('re_password', true);

		$data = [
			'username_user' => $username,
			'nama_user' 	=> $this->input->post('name', true),
		];

		// Jika password dan password konfirmasi berbeda return 
		if ($password != $re_password) {
			$this->session->set_flashdata('msg_error', 'Password tidak sama');
			redirect('app/v1/user');
		}
       
        $check_username = $this->user->cekUsername($username);

		// Jika ditemukan data dengan username tsb
		if (empty($id) && !empty($check_username)) {
			$this->session->set_flashdata('msg_error', 'Username sudah digunakan');
			redirect('app/v1/user');
		}

		// Jika user sudah ada di database lakukan update password
		if ($id){
			if ($password){
				$data['password_user']		= encrypt_pass_format($password);
				$data['updated_pass_at']	= date('Y-m-d H:i:s');
			}

			$this->user->updateData($data, $id);
		}
		// Jika user belum ada maka create user baru
		else{
			$data['password_user'] 	= encrypt_pass_format($password);
			$data['created_at'] 	= date('Y-m-d H:i:s');

			$this->user->insertData($data);
			$id = $this->user->lastId();
		}
    
		$role 	= $this->input->post('role', true);
		$batch 	= [];

		if (!empty($role)) {
			foreach ($role as $key => $value) {
				$batch[] = [
					'id_user' => $id,
					'id_role' => $key
				];
			}

			if($batch){
				$this->user->deleteUserRole($id);
				$this->user->insertUserRole($batch);
			}
		}else{
			$this->user->deleteUserRole($id);
		}

		$this->session->set_flashdata('msg_success', 'User berhasil disimpan');
            
        redirect('app/v1/user');
    }
}