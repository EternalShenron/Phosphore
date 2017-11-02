<?php if( have_rows('restructurating_benefit_cycle') ): ?>
	<?php $i = 1 ?>

	<div class="benefit-cycle owl-carousel row">
	<?php while( have_rows('restructurating_benefit_cycle') ): the_row(); 

		$image = get_sub_field('schema_image');
		$description = get_sub_field('schema_description');
		?>

			<?php if ($i == 1): ?>
				<div class="col-md-4 col-center">
			<?php elseif ($i == 2): ?>
					<div class="col-md-4">
			<?php elseif ($i == 3): ?>
				<div class="col-md-4 col-md-push-4">
			<?php elseif ($i == 4): ?>
				<div class="col-md-4 col-md-push-2" style="clear: both">
			<?php elseif ($i == 5): ?>
				<div class="col-md-4 col-md-push-2">
			<?php endif ?>
					
					<?php if ($image): ?>
						<img src="<?php echo $image['url']; ?>" alt="<?php echo $image['alt'] ?>" />
					<?php else: ?>				
						<div style="width: 100%; height: 300px; background: #ddd"><div class="benefit-step-number h1"><?php echo $i; ?></div></div>
					<?php endif ?>

				    <div class="benefit-step-description"><?php echo $description;; ?></div>
			</div>


		<?php $i++ ?>

	<?php endwhile; ?>

	</div>

<?php endif; ?>

