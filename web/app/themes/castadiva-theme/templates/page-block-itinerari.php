<?php use Roots\Sage\Extras; ?>
<div class="tour-section container" id="tour-section">
    <div class="trapeze pattern" style="background-image:url(<?php echo get_sub_field('pattern')['url']; ?>); background-size: <?php echo get_sub_field('pattern')['width']/2; ?>px <?php echo get_sub_field('pattern')['height']/2; ?>px" ng-sm from="{y : '100%'}" top="{y: '0%'}" duration="200%" trigger-element="#tour-section" offset="-400"></div>
    <div class="trapeze-cover">
        <div class="trapeze-cover-in">
            <div class="trapeze-cover-image" style="background-image:url(<?php echo get_sub_field('tour_img')['url']; ?>)">
                <img src="<?php echo get_sub_field('tour_image')['url']; ?>" alt="<?php get_sub_field('tour_img')['alt']; ?>" class="thumb-hidden" />
            </div>
        </div>
    </div>
    <div class="tour-content" ng-sm from="{y : '-100%'}" top="{y: '0%'}" duration="200%" trigger-element="#tour-section" offset="-400">
        <div class="tour-content-inner">
            <header class="tour-header">
                <h2 class="title light">
                    <?php echo __('I nostri<span>itinerari</span>'); ?>
                </h2>
            </header>
            <div class="content row-top row-md-top">
            <?php the_sub_field('testo'); ?>
            <?php Extras\btn(__('Scopri', 'castadiva'), get_post_type_archive_link('itinerari')); ?>
            </div>
        </div>
    </div>
    <div class="pattern-main" ng-sm from="{y : -50}" top="{y: 0}" duration="200%" trigger-element="#tour-section" offset="-400"></div>
</div>