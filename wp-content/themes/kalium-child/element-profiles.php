<div class="row">
    <div class="col-md-11">
        
        <?php if( have_rows('profile') ): ?>

            <?php 
                $j = 1;
                $k = 0;
                $prev_typical_recruit = '';
            ?>

            <?php while( have_rows('profile') ): the_row(); ?>
                <?php $typical_recruit = get_sub_field('typical_recruit'); ?>
                <?php if ($typical_recruit != $prev_typical_recruit): ?>
                    <?php $k++; ?>
                <?php endif ?>
                <div class="profile" data-profile-group="<?php echo 'profile-group-' . $k ?>">
                    <div class="row">
                        <div class="col-md-5">
                            <div class="trigger-group">
                                <div class="row">
                                    <div class="col-md-6">
                                            <?php 
                                            $typical_recruit = get_sub_field('typical_recruit');
                                            if ($typical_recruit && $typical_recruit != $prev_typical_recruit): ?>
                                                <div class="typical-recruit">
                                                    <?php the_sub_field('typical_recruit'); ?>
                                                </div>
                                            <?php endif ?>                                                                            
                                                    
                                    </div>
                                    <div class="col-md-6">
                                        <div class="panel-heading profile-item profile-item-<?php echo $j ?> wow animated fadeIn">
                                            <a class="profile-link box position" role="button" data-toggle="collapse" href="#profile-detail-<?php echo $j ?>" aria-expanded="false" aria-controls="profile-detail-<?php echo $j ?>">
                                              <div class="h4"><?php the_sub_field('position') ?></div>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 profile-detail-container">
                            <div class="collapse profile-detail" id="profile-detail-<?php echo $j ?>" aria-expanded="false" style="height: 0px;">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="box team-project-role">
                                            <h5>Team project role</h5>
                                            <?php the_sub_field('team__project_role') ?>
                                        </div>
                                    </div>    
                                    <div class="col-md-6">
                                        <div class="box client-role">
                                            <h5>Client role</h5>
                                            <?php the_sub_field('client_role') ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div> 
                    <?php $typical_track = get_sub_field('typical_track') ?>
                    <?php if ($typical_track): ?>
                        <?php if ($typical_track < 1) {
                            $typical_track = 0;
                        } ?>
                        
                        <div class="xp-level small"><?php echo $typical_track . ' years'; ?></div>
                    <?php endif ?>
                </div>
                <?php $j++ ;
                $prev_typical_recruit = $typical_recruit;
                ?>

            <?php endwhile; ?>
            
            <div class="xp-axis"></div>

        <?php endif; ?>

    </div>
</div>