<div class="col-xs-12 col-sm-4">
    <?php if (get_field('industrie')): ?>   
        <div class="example-industry">
            <h4>Industry</h4>
            <p><b><?php the_field('industrie') ?></b></p>
        </div>
        <div class="divider"></div>
    <?php endif ?>

    <?php if( have_rows('business_issues') ): ?>
        <h4>Business issues</h4>
        <ul class="business-issues">
        <?php while( have_rows('business_issues') ): the_row(); 
            $business_issue = get_sub_field('business_issue');
            ?>
            <li class="business-issue">
                <?php echo $business_issue ?>
            </li>
        <?php endwhile; ?>
        </ul>
    <?php endif; ?>
</div>
<?php if (get_field('our_impact')): ?>
    <div class="col-xs-12 col-sm-4">
        <div class="our-impact">
            <h4>Our impact</h4>
            <div class="our-impact-content">
                <?php the_field('our_impact') ?>
            </div>
            <?php if (get_field('consequences_of_our_impact')): ?>
            <div class="consequences-of-our-impact-content">
                <?php the_field('consequences_of_our_impact') ?>
            </div>
            <?php endif ?>
        </div>
    </div>
<?php endif ?>
<?php if (get_field('our_approach')): ?>
    <div class="col-xs-12 col-sm-4">
        <div class="our-approach">
            <h4>Our approach</h4>
            <div class="our-approach-content">
                <?php the_field('our_approach') ?>
            </div>
        </div>
    </div>
<?php endif ?>
<?php if (get_field('related_article')): ?>
    <div class="col-xs-12">
        <?php $related_article = get_field('related_article') ?>
        <div class="divider"></div>
        <div class="text-center"><a href="<?php echo $related_article->guid ?>" class="btn">Read more</a></div>
    </div>
<?php endif ?>