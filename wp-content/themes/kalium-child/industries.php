<div id="industries-section">

	<div class="row">

			<?php while( have_rows('columns') ): the_row(); ?>
				<div class="col-lg-2">
					<h3><?php the_sub_field('column_name'); ?></h3>
					<?php if( have_rows('industries_in_this_category') ): ?>
						<div class="column-content">
						<?php while( have_rows('industries_in_this_category') ): the_row(); ?>
							<?php $linked = (get_sub_field('linked') == true ? ' linked' : ''); ?>
							<?php if (have_rows('group')): ?>
								<div class="group<?php echo $linked ?>">
								
									<?php while( have_rows('group') ): the_row(); 

										$color = get_sub_field('color');
										?>									

										<div class="h4 industry <?php echo $color ?>"><?php the_sub_field('industry') ?></div>
									<?php endwhile; ?>

								</div>
							<?php endif ; ?>
						<?php endwhile; ?>
						</div>
					<?php endif; ?>
				</div>	
			<?php endwhile; ?>

	</div>

</div>