<?php 
    $kind = get_sub_field('kind'); 
    $elementClass = ($kind < 1) ? 'product-category-' : 'team-'; 
    $items = ($kind < 1) ? get_sub_field('categorie') : get_sub_field('team'); 
?>
<div class="container">
    <ul class="<?php echo $elementClass; ?>columns columns grid-<?php echo count($items); ?>">
        <?php foreach($items as $item) : ?>
        <li class="columns-item <?php echo $elementClass; ?>column-item col-1">
            <?php 
                   // VIDEO
                   if(get_sub_field('video') != '') : ?>
            <?php $file = preg_replace('/\\.[^.\\s]{3,4}$/', '', get_sub_field('video')['url']); ?>
            <div class="video-cover" style="background-image:url(<?php echo $file; ?>.jpg)">
                <video class="video-item" ng-video loop poster="<?php echo $file; ?>.jpg">
                    <source src="<?php echo $file; ?>.mp4" type="video/mp4" />
                    <source src="<?php echo $file; ?>.ogv" type="video/ogv" />
                    <source src="<?php echo $file; ?>.webm" type="video/webm" />
                </video>
            </div>
            <?php 
                   // ENDVIDEO
                   endif; ?>
            <div class="columns-item-content">
            <?php if($kind < 1) : ?>
            <h3 class="title">
                <?php the_field('product_cat_title', 'product_cat_'.$item); ?>
            </h3>
            <a href="<?php echo get_term_link($item); ?>" class="btn">
                <span class="btn-text" style="color: <?php the_field('color', 'product_cat_'.$item); ?>"><?php echo __('Guarda', 'castadiva'); ?></span>
            </a>
            <a href="<?php echo get_term_link($item); ?>" class="permalink"><?php echo get_term_by('id', $item, 'product_cat')->name; ?></a>
            <?php else : ?>
            <h3 class="title">
                <?php the_field('team_title', 'user_'.$item); ?>
            </h3>
            <?php endif; ?>
            </div>
        </li>
        <?php endforeach; ?>
    </ul>
</div>