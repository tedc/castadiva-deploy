<div class="instagram-container container" id="instagram">
    <a href="<?php echo get_option('social_settings')['instagram']; ?>" class="btn instagram-btn">
        <span class="btn-text">
            <i class="fa fa-instagram"></i><br />
            <?php echo __('Seguici su<br/>Instagram<br/><small>@castadiva</small>', 'castadiva'); ?>
        </span>
    </a>
    <div class="instagram"  ng-instagram></div>
</div>