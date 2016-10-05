<ng-carousel>
<?php 
    $imgs = get_field('gallery');
    $total = count($imgs);
    $count = 0; ?>
    <ul class="carousel-wrapper slider-wrapper" ng-swipe-right="dir(false, pos, <?php echo $total - 1; ?>)" ng-swipe-left="dir(true, pos, <?php echo $total - 1; ?>)">
        <?php foreach($imgs as $img) : ?>
            <li class="carousel-item recipe-item<?php echo ($count == 0) ? ' current' : ''; ?>" ng-class="{current : pos == <?php echo $count; ?>}" style="background-image: url(<?php echo $img['url']; ?>)">
                <img src="<?php echo $img[0]['full']; ?>" class="hidden-img" alt="<?php echo $img['alt']; ?>" />
            </li>
        <?php  $count++; endforeach; ?>
    </ul>
    <div class="main-header-content">
        <h1 class="title"><?php the_title(); ?></h1>
        <?php if(is_page()) : ?>
        <div class="content row row-md">
            <?php the_content(); ?>
        </div>
    </div>
    <nav class="carousel-nav-container">
        <span class="arrow arrow-left" ng-click="dir(false, pos, <?php echo $total - 1; ?>)" ng-class="{inactive : pos == 0}"><span class="arrow-text">&lsaquo;</span></span>
        <span class="arrow arrow-right" ng-click="dir(true, pos, <?php echo $total - 1; ?>)" ng-class="{inactive : pos == <?php echo $total - 1; ?>}"><span class="arrow-text">&rsaquo;</span></span>
    </nav>
</ng-carousel>