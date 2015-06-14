<!-- NAV -->

<div class="nav">
	<ul>
		<li><a href="<?php echo base_url() . 'site/home'; ?>">Home</a></li>
		<li><a href="<?php echo base_url() . 'site/about'; ?>">About</a></li>
		<li><a href="<?php echo base_url() . 'site/contact'; ?>">Contact</a></li>
		<?php
			if ( $access == 1) {
		?>
			<li><a href="<?php echo base_url() . 'site/admin_pannel'; ?>">Admin Pannel</a></li>
		<?php
			}
			else {
		?> 
			<li><a href="<?php echo base_url() . 'site/profile'; ?>">Profile</a></li>
				
		<?php
			} 
		?>
		<li><a href="<?php echo base_url() . 'site/logout'; ?>">Sign Out</a></li>
	</ul>
</div>