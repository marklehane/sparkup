<?php $atts = array('id' => 'login_form', 'class' => 'form-signin', 'role' => 'form'); ?>
<?php echo form_open('admin/users/login', $atts); ?>
	<h2 class="form-signin-heading">Sparkup Admin Login</h2>
	<?php echo validation_errors('<p class="alert alert-danger">'); ?>
	<?php if ($this->session->flashdata('success')): ?>
	<?php echo '<div class="alert alert-success">' . $this->session->flashdata('success') . '</div>'; ?>
	<?php endif;?>

	<?php if ($this->session->flashdata('error')): ?>
		<?php echo '<div class="alert alert-danger">' . $this->session->flashdata('error') . '</div>'; ?>
	<?php endif;?>
	<label for="username" class="sr-only">Username</label>
	<input type="text" name="username" id="username" class="form-control" placeholder="Username" required autofocus>
	<br>
	<label for="password" class="sr-only">Password</label>
	<input type="password" name="password" id="password" class="form-control" placeholder="Password" required>
	<button class="btn btn-lg btn-primary btn-block" type="submit">Sign in</button>
<?php echo form_close(); ?>