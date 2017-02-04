<?php if ($featured_pages): ?>
	<?php foreach ($featured_pages as $page): ?>
		<div class="featued-page">
			<h2 class="page-header"><?php echo$page->title; ?></h2>
			<?php echo $page->body; ?>
		</div>
	<?php endforeach;?>
<?php endif;?>