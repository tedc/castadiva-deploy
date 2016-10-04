<div class="container">
    <div class="map">
        <ng-map map-data="[[<?php echo get_sub_field('coordinate')['lat']; ?>, <?php echo get_sub_field('coordinate')['lng']; ?>]]"></ng-map>
        <div class="trapeze-out map-content" ng-class="{hidden: isInfo}">
            <div class="trapeze-out-content row-lg row">
                <?php the_sub_field('testo'); ?>
            </div>
        </div>
        <nav class="zoom">
            <span ng-click="zoom(true)" class="white">+</span>
            <span ng-click="zoom(false)" class="white">-</span>
        </nav>
    </div>
</div>