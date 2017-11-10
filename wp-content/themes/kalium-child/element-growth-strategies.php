<div class="row" style="margin-top: 50px">
	<div class="col-md-6">
		<div class="h4">Higher free Cash flows from growth initiatives...</div>
		<div style="height:300px; background: #ddd; margin-bottom: 30px"></div>
	</div>
	<div class="col-md-6">
		<div class="h4">...and valuation geared by higher ratios</div>
		<div style="height:300px; background: #ddd; margin-bottom: 30px"></div>
	</div>
	<div class="col-xs-12">
		<div class="row">
			<div class="col-md-8 col-center">
				<?php if( have_rows('elements') ): ?>
				<div class="growth-3">

					<?php while( have_rows('elements') ): the_row(); ?>

					<div class="row growth-3-element">
						<div class="col-sm-4 match-height-by-row">
							<div class="growth-3-element-title">
								<div class="h4"><?php the_sub_field('titre_element') ?></div>
							</div>
						</div>
						<div class="col-sm-8 match-height-by-row growth-3-element-text-container">
							<div class="growth-3-element-text">
								<?php the_sub_field('contenu_element') ?>
							</div>
						</div>
					</div>

					<?php endwhile; ?>

					<div class="growth-3-axis">
						<div class="growth-3-axis-start-label"><small>Existing assets portfolio (products x customers x plants)</small></div>
						<div class="growth-3-axis-end-label"><small>New assets portfolio</small></div>
					</div>

				</div>
				<?php endif; ?>
			
			</div>
		</div>
	</div>
</div>