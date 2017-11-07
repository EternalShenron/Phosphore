<div id="industries-section">

	<div class="row">
		
			<?php 
			$i = 1;
			while( have_rows('columns') ): the_row(); ?>
				<div class="col-xs-12 col-md-3 col-lg-2 match-height-by-row">
					<div class="industry-item">
						<div class="panel-heading match-height text-center" role="tab" id="heading-<?php echo $i ?>">
							<a class="industry-link" role="button" data-toggle="collapse" href="#industry-detail-<?php echo $i ?>" data-href="#industry-detail-<?php echo $i ?>" aria-expanded="true" aria-controls="industry-detail-<?php echo $i ?>">
								<h3 class="h4 text-center"><?php the_sub_field('column_name'); ?></h3>
							</a>
						</div>
						<?php if( have_rows('industries_in_this_category') ): ?>
							<div class="collapse in industry-detail" id="industry-detail-<?php echo $i ?>" aria-expanded="true">
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
							</div>
						<?php endif; ?>
					</div>
				</div>

			<?php 
			$i++;
			endwhile; ?>

	</div>

</div>