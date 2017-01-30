<h2 class="page-header">Pages</h2>

<?php if ($this->session->flashdata('success')): ?>
	<?php echo '<div class="alert alert-success">' . $this->session->flashdata('success') . '</div>'; ?>
<?php endif;?>

<?php if ($this->session->flashdata('error')): ?>
	<?php echo '<div class="alert alert-danger">' . $this->session->flashdata('error') . '</div>'; ?>
<?php endif;?>

<?php if ($pages): ?>

<table class="table table-striped">
	<tr>
		<th>ID</th>
		<th>Published</th>
		<th>Title</th>
		<th>Author</th>
		<th>Date Created</th>
		<th></th>
	</tr>
	<?php foreach ($pages as $page): ?>
	<?php $date           = strtotime($page->create_date);?>
	<?php $formatted_date = date('F j, Y, g:i a', $date);?>
	<tr>
		<td><?php echo $page->id; ?></td>
		<td><?php echo $page->is_published; ?></td>
		<td><?php echo $page->title; ?></td>
		<td><?php echo 'SOME USER'; ?></td>
		<td><?php echo $formatted_date; ?></td>
		<td>
			<?php echo anchor('admin/pages/edit/' . $page->id . '', 'Edit', 'class="btn btn-default"'); ?>
			<?php echo anchor('admin/pages/delete/' . $page->id . '', 'Delete', 'class="btn btn-danger"'); ?>
		</td>
	</tr>
	<?php endforeach;?>
</table>

<?php else: ?>
	<p>No Pages</p>
<?php endif; ?>