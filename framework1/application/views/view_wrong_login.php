<!--WRONG_LOGIN__PAGE-->

<!DOCTYPE html>
<html>
<head>
	<title>Wrong Password!</title>
	<link rel="stylesheet" href="<?php echo base_url('assets/css/login.css'); ?>">
</head>
<body>
<div class="container">
	<h1> You've entered a wrong username or login, please try again </h1>

	<?php

	echo form_open('site/login_validation');
		echo "<p>Username: ";
		echo form_input('username');
		echo "</p>";

		echo "<p>Email: ";
		echo form_input('email');
		echo "</p>";

		echo "<p> Password: ";
		echo form_password('password');
		echo "</p>";

		echo "<p>";;
		echo form_submit('login_submit', 'Login');
		echo "</p>";
	echo form_close();

	?>
</div>
</body>
</html>