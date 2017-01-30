<h2 class="page-header">Add Page</h2>
<?php echo validation_errors('<p class="alert alert-danger">'); ?>
<?php echo form_open('admin/pages/add'); ?>
	<div class="form-group">
		<?php echo form_label('Page Title', 'title'); ?>
		<?php
$data = array(
    'name'      => 'title',
    'id'        => 'title',
    'maxlength' => '100',
    'class'     => 'form-control',
    'value'     => set_value('title'),
);
?>
		<?php echo form_input($data); ?>
	</div>

	<!-- Page Subject -->
	<div class="form-group">
		<?php echo form_label('Subject', 'subject_id'); ?>
		<?php echo form_dropdown('subject_id', $subject_options, 0, array('class' => 'form-control')); ?>
	</div>

	<!-- Page Body -->
	<div class="form-group">
		<?php echo form_label('Body', 'body'); ?>
		<?php
$data = array(
    'name'  => 'body',
    'id'    => 'body',
    'class' => 'form-control',
    'value' => set_value('subject'),
);
?>
		 <?php echo form_textarea($data); ?>
	</div>

	<!-- Publish -->
	<div class="form-group">
		<?php echo form_label('Published', 'is_published'); ?>
		<?php echo form_radio('is_published', 1, true) ?> Yes
		<?php echo form_radio('is_published', 0, false) ?> No
	</div>

	<!-- Feature -->
	<div class="form-group">
		<?php echo form_label('Feature', 'is_featured'); ?>
		<?php echo form_radio('is_featured', 1, false) ?> Yes
		<?php echo form_radio('is_featured', 0, true) ?> No
	</div>

	<!-- Menu -->
	<div class="form-group">
		<?php echo form_label('Add To Menu', 'in_menu'); ?>
		<?php echo form_radio('in_menu', 1, true) ?> Yes
		<?php echo form_radio('in_menu', 0, false) ?> No
	</div>

	<!-- Order -->
	<div class="form-group">
		<?php echo form_label('Order', 'order'); ?>
		<input class="form-control" type="number" name="order" id="order">
	</div>

	<?php echo form_submit('mysubmit', 'Add Page', array('class' => 'btn btn-primary')); ?>
<?php echo form_close(); ?>