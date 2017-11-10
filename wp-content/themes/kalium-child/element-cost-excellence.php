<?php if( have_rows('restructurating_benefit_cycle') ): ?>
	<?php $i = 1 ?>

	<div class="benefit-cycle owl-carousel row">
	<?php while( have_rows('restructurating_benefit_cycle') ): the_row(); 

		$image = get_sub_field('schema_image');
		$description = get_sub_field('schema_description');
		?>
<!--  -->
			<?php if ($i == 1): ?>
				<div class="col-md-5 col-center">
			<?php elseif ($i == 2): ?>
				<div class="col-md-5">
			<?php elseif ($i == 3): ?>
				<div class="col-md-5">
			<?php elseif ($i == 4): ?>
				<div class="col-md-5" style="clear: both">
			<?php elseif ($i == 5): ?>
				<div class="col-md-5">
			<?php endif ?>

				<div class="benefit-step">

					<div class="benefit-step-content">
						<div class="benefit-step-graphic">
							<?php if ($image): ?>
								<img src="<?php echo $image['url']; ?>" alt="<?php echo $image['alt'] ?>" />
							<?php else: ?>				
								<div class="benefit-step-placeholder"><!-- <div class="benefit-step-number h1"><?php echo $i; ?></div> --></div>
							<?php endif ?>
						</div>
					    <div class="benefit-step-description-container">
						    <div class="benefit-step-description">
						    	<?php echo $description;; ?>
						    </div>
						</div>
						<!-- <div class="benefit-step-shadow"></div> -->

					</div>

					<div class="benefit-step-number"><?php echo $i; ?></div>

				</div>
			</div>


		<?php $i++ ?>

	<?php endwhile; ?>

	</div>

<?php endif; ?>

