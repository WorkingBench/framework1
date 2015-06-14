<!DOCTYPE html>
<html>
<head>
	<title>Welcome!</title>
	<link href='http://fonts.googleapis.com/css?family=Old+Standard+TT' rel='stylesheet' type='text/css'>
	<link href='http://fonts.googleapis.com/css?family=Lobster' rel='stylesheet' type='text/css'>
	<link rel="stylesheet" href="<?php echo base_url('assets/css/login.css'); ?>">
</head>
<body>
<div class="container">
	<h1> Sign In </h1>

	<?php

	echo form_open('site/login_validation');

		echo validation_errors();
		echo "<p>Username: ";
		echo form_input('username');
		echo "</p>";
		
		echo "<p>Email: ";
		echo form_input('email', $this->input->post('email'));
		echo "</p>";

		echo "<p> Password: ";
		echo form_password('password');
		echo "</p>";

		echo "<p>";
		echo form_submit('login_submit', 'Login');
		echo "</p>";
	echo form_close();

	?>
	<div class="svg-wrapper">
  		<svg height="60" width="320" xmlns="http://www.w3.org/2000/svg">
    		<rect class="shape" height="60" width="320" />
    		<div class="text">
    			<a href="<?php echo base_url() . 'site/signup'; ?>">Sign Up!</a>
    		</div>
  		</svg>
	</div>
</div>	
</body>
</html>