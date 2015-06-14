	<!--BODY_ADMIN_PANNEL-->

	<div class="admin">
		<h1 id="text_admin">Admin users control</h1>
		<p id="text_admin">
		</p>
		<div class='container'>
			<table id="table">
				<tr><td width="150px"><b>Users</b></td><td><b>Email</b></td><td><b>Type</b></td><td><b>Option</b></td></tr>
					<?php foreach($query as $row): ?>
				<tr> 

   					<td><?php echo $user = $row->username; ?></td>
    				<td><?php echo $row->email; ?></td>
    				<td><?php echo $row->type; ?></td>
    				<td id="delete"><a href="<?php echo base_url() . 'site/delete/'; echo $user;?>">Delete</a></td>

    			</tr>
    			<?php endforeach; ?>
    			<tr><td><i>M = Member</i></td><td><i>A = Admin</i></td></tr>
			</table>
			<div id="button">
				<a href="<?php echo base_url() . 'site/home' ?>" data-text="Home" class="button-hover">Back</a>
			</div>
		</div>
			<div class="bottom">
				<div class="explore_more">
					<div class="event">
						<h3>Explore the night life</h3>
						<p>Don't let the events slip away. This the explorer starter pack</p>
					</div>
					<div class="event">
						<h3>Forever young</h3>
						<p>Cluj-Napoca is the European Youth Capital in 2015, a title won during a competition that had 49 European countries as participants. Take the tour of the upcoming events</p>
					</div>
					<div class="event">
						<h3>We recomend</h3>
						<p>The most anticipated festival is back. Get your ticket now!</p>
					</div>
				</div>
