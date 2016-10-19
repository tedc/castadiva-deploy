<?php use Roots\Sage\Extras; ?>
<?php $btnClass = 'btn';
    if(is_singular('post')) {
        $btnClass .= ' news-btn';
    } elseif(is_singular('ricette')) {
        $btnClass .= ' recipes-btn';
    } ?>
<nav class="post-tools">
<div class="share">
    <a class="<?php echo $btnClass; ?>" ng-click="$event.preventDefault(); isShare = !isShare">
        <span class="btn-text">
            <?php echo __('Share', 'castadiva'); ?>
        </span>
    </a>

    <?php $socials = array(
        "facebook" => "https://www.facebook.com/sharer/sharer.php?u=",
        "twitter" => "http://twitter.com/share?url=",
        "google-plus" => "https://plus.google.com/share?url=",
        "pinterest" => "https://www.pinterest.com/pin/create/button/"
    ); ?>
    <nav class="social-share" ng-class="{visible:isShare}">
        <?php foreach($socials as $key => $s) : ?>
        <a href="<?php echo $s; ?><?php the_permalink(); ?><?php if($key =='twitter') : ?>&amp;url=<?php the_title(); ?><?php endif; ?>" class="social-share-item <?php echo $btnClass; ?>" target="_blank"<?php if($key=='pinterest'): ?> data-pin-do="buttonBookmark"
       data-pin-custom="true"<?php endif; ?>>
            <i class="fa fa-<?php echo $key; ?> btn-text">
            </i>
        </a>    
        <?php if($key=='pinterest') :
            echo '<script async defer src="//assets.pinterest.com/js/pinit.js"></script>';
            endif; ?>
        <?php endforeach; ?>
    </nav>
</div>

</nav>
