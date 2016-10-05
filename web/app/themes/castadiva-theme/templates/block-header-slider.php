<?php 
use Roots\Sage\Extras;
// IF HEADER
if(have_rows('header')) : ?>

<?php 
$total = count(get_field('header'));
if($total > 1) : ?>
<div class="carousel-wrapper slider-wrapper full-slider" ng-swipe-right="dir(false, pos, <?php echo $total - 1; ?>)" ng-swipe-left="dir(true, pos, <?php echo $total - 1; ?>)" ng-carousel full-slider="true">
<?php endif; ?>

<?php $count = 0;
    while(have_rows('header')) : the_row(); ?>
    <?php $style = (get_sub_field('slider_img') != '') ? ' style="background-image: url('.get_sub_field('slider_img').')"' : ''; ?>
    <?php if($total > 1) : ?>
    <div class="carousel-item <?php echo ($count == 0) ? ' current' : ''; ?> cover" ng-class="{current : pos == <?php echo $count; ?>}"<?php echo $style; ?>>
        <?php 
               // VIDEO
               if(get_sub_field('video') != '') : ?>
        <?php $file = preg_replace('/\\.[^.\\s]{3,4}$/', '', get_sub_field('video')['url']); ?>
        <div class="video-cover<?php echo (is_singular('product')) ? ' product-cover' : ''; ?>" style="background-image:url(<?php echo $file; ?>.jpg)">
            <video class="video-item" ng-video loop poster="<?php echo $file; ?>.jpg">
                <source src="<?php echo $file; ?>.mp4" type="video/mp4" />
                <source src="<?php echo $file; ?>.ogv" type="video/ogv" />
                <source src="<?php echo $file; ?>.webm" type="video/webm" />
            </video>
        </div>
        <?php 
               // ENDVIDEO
               endif; ?>
        <?php if(!is_singular('product')) : ?>
        <div class="main-header-content">
        <?php endif; ?>
    <?php else : ?>
    <?php 
               // VIDEO
               if(get_sub_field('video') != '') : ?>
        <?php $file = preg_replace('/\\.[^.\\s]{3,4}$/', '', get_sub_field('video')['url']); ?>
        <div class="video-cover<?php echo (is_singular('product')) ? ' product-cover' : ''; ?>" style="background-image:url(<?php echo $file; ?>.jpg)">
            <video class="video-item" ng-video loop poster="<?php echo $file; ?>.jpg">
                <source src="<?php echo $file; ?>.mp4" type="video/mp4" />
                <source src="<?php echo $file; ?>.ogv" type="video/ogv" />
                <source src="<?php echo $file; ?>.webm" type="video/webm" />
            </video>
        </div>
        <?php 
               // ENDVIDEO
               else : ?>
        <div class="product-cover" style="background-image: url(<?php the_sub_field('slider_img'); ?>)">
            
        </div>
        <?php endif; ?>
    <?php if(!is_singular('product')) : ?><div class="main-header-content"<?php echo $style; ?>><?php endif; ?>
    <?php endif; ?>
        
        <?php 
               // VARIABILI COMUNI
               $title = (get_sub_field('tipo_di_titolo') == 1) ? get_the_title() : get_sub_field('titolo');
               $h = ($total > 1) ? 'h2' : 'h1';
        ?>
        
        
        <?php 
               // LOGO
               if(get_sub_field('logo') != '') : ?>
            <?php if(get_sub_field('logo') == 'full-logo-title') : ?>
            <?php echo '<'.$h .' class="'. get_sub_field('logo') .'">'.$title.'</'.$h.'>'; ?>
            <?php else : ?>
            <i class="<?php the_sub_field('logo'); ?>"></i>
            <?php endif; ?>
        <?php 
               // ENDLOGO
               endif; ?>
            <?php if(get_sub_field('logo') != 'full-logo-title') : ?>
            <?php echo '<'.$h .' class="title">'.$title.'</'.$h.'>'; ?>
            <?php endif; ?>
            <?php if(get_sub_field('contenuto') != '') : ?>
                <div class="content row row-md">
                    <?php if(get_sub_field('contenuto') == 1) : ?>
                    <?php the_content(); ?>
                    <?php else : ?>
                    <?php the_sub_field('testo'); ?>
                    <?php while(the_flexible_field('bottone')) : ?>      
                    <?php Extras\btn($text = get_sub_field('btn-text'), $link = get_sub_field('link'), null, null, null, 'inverted-btn'); ?>
                    <?php endwhile; ?>
                    <?php endif; ?>
                </div>
            <?php endif; ?>
    <?php if($total > 1) : ?>
        <?php if(!is_singular('product')) : ?></div><?php endif; ?>
    </div>
    <?php else : ?>
     <?php if(!is_singular('product')) : ?></div><?php endif; ?>
    <?php endif; ?> 
<?php $count++; endwhile; ?>
<?php if($total > 1) : ?>
</ul>
<nav class="carousel-nav-container">
    <span class="arrow arrow-left" ng-click="dir(false, pos, <?php echo $total - 1; ?>)" ng-class="{inactive : pos == 0}"><span class="arrow-text">&lsaquo;</span></span>
    <span class="arrow arrow-right" ng-click="dir(true, pos, <?php echo $total - 1; ?>)" ng-class="{inactive : pos == <?php echo $total - 1; ?>}"><span class="arrow-text">&rsaquo;</span></span>
</nav>
</ng-carousel>
<?php endif; ?>
<?php
// ELSE NOT HEADER
else : ?>
<?php if(!is_singular('product')) : ?>
<div class="main-header-content" style="background-image: url(<?php echo the_post_thumbnail_url('full'); ?>)">
    <i class="flowers"></i>
    <h1 class="title"><?php the_title(); ?></h1>
    <?php if(is_page() && !is_front_page()) : ?>
    <div class="content row row-md">
        <?php the_content(); ?>
    </div>
    <?php endif; ?>
</div>
<?php endif; ?>
<?php 
// END IF HEADER
endif; ?>