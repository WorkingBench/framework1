<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Site extends CI_Controller {
	public function index() {
		$this->login();
	}

	public function login() {
		$this->load->view('view_login');
	}

	public function signup() {
		$this->load->view('view_signup');
	}

	public function login_validation() {
		$this->load->library('form_validation');
		$this->load->model('model_users');

		$this->form_validation->set_rules('username', 'Username', 'required|callback_validate_credentials_user');
		$this->form_validation->set_rules('email', 'Email', 'required|trim|xss_clean|callback_validate_credentials_email');
		$this->form_validation->set_rules('password', 'Password', 'required|md5|callback_validate_credentials_pass');

		if ($this->form_validation->run()) {
			$email = $this->input->post('email');
			if ($this->model_users->user_type($email) == 1)
				$data = array(
						'email' => $this->input->post('email'),
						'is_logged_in' => 1,
						'type' => 1
					);
			else
				$data = array(
					'email' => $this->input->post('email'),
					'is_logged_in' => 1,
					'type' => 2
				);
			$this->session->set_userdata($data);
			redirect('site/home');
		}
		else {
			$this->load->view('view_login');
		}
	}

	public function signup_validation() {
		$this->load->library('form_validation');

		$this->form_validation->set_rules('username', 'Username', 'required|trim|is_unique[users.username]');
		$this->form_validation->set_rules('email', 'Email', 'required|trim|valid_email|is_unique[users.email]');
		$this->form_validation->set_rules('password', 'Password', 'required|trim');
		$this->form_validation->set_rules('cpassword', 'Re-type password', 'required|trim|matches[password]');

		$this->form_validation->set_message('is_unique', 'That input data already exists!');

		if ($this->form_validation->run()) {
			//generate a random key
			$key = md5(uniqid());
			
			//send email to the use
			$this->load->library('email', array('mailtype' => 'html'));
			$this->load->model('model_users');

			$this->email->from('me@mywebsite.com', 'Camarasan');
			$this->email->to($this->input->post('email'));
			$this->email->subject("Confirm your account.");

			$message = "<p>Thank you for signing up!</p>";
			$message = "<p><a href='" . base_url() . "site/register_user/$key'>Click Here</a> to confirm your account</p>";
			
			$this->email->message($message);
			if ($this->model_users->add_temp_users($key)) {
				if ($this->email->send()) {
					echo "The confirmation email has been sent!";
				}
				else
					echo "Email failed to send.";
			}
			else
				echo "Error when adding to database.";
		}
		else{

			$this->load->view('view_signup');
		}
	}

	public function validate_credentials_user() {
		$this->load->model('model_users');

		if ($this->model_users->can_log_in()) {
			return true;
		}
		else {
			$this->form_validation->set_message('validate_credentials_user', 'Incorrect username.');
			return false;
		}
	}

	public function validate_credentials_email() {
		$this->load->model('model_users');

		if ($this->model_users->can_log_in()) {
			return true;
		}
		else {
			$this->form_validation->set_message('validate_credentials_email', 'Incorrect email.');
			return false;
		}
	}

	public function validate_credentials_pass() {
		$this->load->model('model_users');

		if ($this->model_users->can_log_in()) {
			return true;
		}
		else {
			$this->form_validation->set_message('validate_credentials_pass', 'Incorrect password.');
			return false;
		}
	}

	public function restricted() {
		$this->load->view('view_restricted');
	}

	public function logout() {
		$this->session->sess_destroy();
		redirect('site/login');
	}

	public function register_user($key) {
		$this->load->model('model_users');

		if ($this->model_users->is_key_valid($key))
		{
			if ($newuser = $this->model_users->add_user($key)) {
				$data = array(
						'username' => $newuser,
						'is_logged_in' => 1
					);
				$this->session->set_userdata($data);
				redirect('site/home');
			}
			else
				echo "Failed to add user, please try again.";
		}
		else
			echo "Invalid key";
	}

	public function home() {
		$this->load->model('model_users');
		$data['access'] = $this->session->userdata('type');
		$data['title'] = "Youth Community";
		if ($this->session->userdata('is_logged_in')) {
			$this->load->view('view_header', $data);
			$this->load->view('view_nav');
			$this->load->view('view_home');
			$this->load->view('view_footer');
		}
		else {
			redirect('site/restricted');
		}
	}

	public function about() {
		if ($this->session->userdata('is_logged_in')) {
			$this->load->model('model_users');
			$data['access'] = $this->session->userdata('type'); 
			$data['title'] = "About";
			$this->load->view('view_header', $data);
			$this->load->view('view_nav');
			$this->load->view('view_body_about');
			$this->load->view('view_footer');
		}
		else
			redirect('site/restricted');
	}

	public function contact() {
		if ($this->session->userdata('is_logged_in')) {
			$this->load->model('model_users');
			$data['access'] = $this->session->userdata('type'); 
			$data['title'] = "Contact";
			$this->load->view('view_header', $data);
			$this->load->view('view_nav');
			$this->load->view('view_body_contact');
			$this->load->view('view_footer');
		}
		else
			redirect('site/restricted');
	}

	public function profile() {
		if ($this->session->userdata('is_logged_in')) {
			$this->load->model('model_users');
			$data['access'] = $this->session->userdata('type');
			$data['title'] = "Profile";
			$this->load->view('view_header', $data);
			$this->load->view('view_nav');
			$this->load->view('view_body_profile');
			$this->load->view('view_footer');
		}
		else
			redirect('site/restricted');
	}

	public function admin_pannel() {
		$this->viewauction();
	}

	public function viewauction() {
        $this->load->model('model_users');
        $data ['query'] = $this->model_users->viewauction();
		if ($this->session->userdata('is_logged_in')) {
			$this->load->model('model_users');
			$data['access'] = $this->session->userdata('type'); 
			$data['title'] = "Admin Pannel";
			$this->load->view('view_header', $data);
			$this->load->view('view_nav');
			$this->load->view('view_body_admin_pannel');
			$this->load->view('view_footer');
		}
		else
			redirect('site/restricted');
    }

    public function delete($user) {
    	$this->load->model('model_users');
    	if ($this->model_users->delete_user($user))
    		echo "DELETED succesfull";
    	else
    		echo "FAILED to delete";
    	$this->viewauction();
    }
}