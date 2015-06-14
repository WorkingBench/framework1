<?php

class Model_users extends CI_Model {

	public function can_log_in() {
		$this->db->where('username', $this->input->post('username'));
		$this->db->where('email', $this->input->post('email'));
		$this->db->where('password', md5($this->input->post('password')));
		$query = $this->db->get('users');

		if ($query->num_rows() == 1) {
			return true;
		}
		else
			return false;
	}

	public function add_temp_users($key) {
		$data = array(
				'username' =>$this->input->post('username'),
				'email' => $this->input->post('email'),
				'password' => md5($this->input->post('password')),
				'key' => $key
			);

		$query = $this->db->insert('temp_users', $data);
		if ($query)
			return true;
		else
			return false;
	}

	public function is_key_valid($key) {
		$this->db->where('key', $key);
		$query = $this->db->get('temp_users');

		if ($query->num_rows() == 1){
			return true;
		}
		else
			return false;
	}

	public function add_user($key) {
		$this->db->where('key', $key);
		$temp_users = $this->db->get('temp_users');

		if ($temp_users) {
			$row = $temp_users->row();
			$data = array(
					'username' => $row->username,
					'email' => $row->email,
					'password' => $row->password,
					'type' => 'M'
				);

			$did_add_user = $this->db->insert('users', $data);
			if ($did_add_user) {
				$this->db->where('key', $key);
				$this->db->delete('temp_users');
				return $data['username'];
			}
		}
		else
			return false;
	}


	public function user_type($email) {
		$this->db->where('email', $email);
		$query = $this->db->get('users');
		$type = $query->result_array();
		if ($type[0]['type'] == 'M')
			return (2);
		else
			return (1);
	}

	public function viewauction() {
    	$query = $this->db->select('*')->from('users')->get();
    	return $query->result();
	}

	public function delete_user($user) {
		$this->db->where('username', $user);
		$data = $this->db->get('users');
		if ($data)
		{
			$this->db->where('username', $user);
			$this->db->delete('users');
			return true;
		}
		return false;

	}
}

?>