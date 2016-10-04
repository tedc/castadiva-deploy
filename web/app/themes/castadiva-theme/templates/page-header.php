<?php use Roots\Sage\Titles; ?>
<?php if(is_page_template('template-custom.php') || is_front_page()) : ?>
<header class="main-header" ng-sm to="{y : -100}" trigger-hook="onLeave" duration="100%">
    <?php get_template_part('templates/block', 'header'); ?>
</header>
<?php else : ?>
<?php if(is_post_type_archive('ricette') || is_tax('recipe_cat')) : ?>
<div class="page-header container content row-lg-top row-top">
    <?php if(!is_tax('recipe_cat')) : ?>
    <h1 class="title light"><?php echo __('Le ricette<br /><strong>di Castadiva</strong>', 'castadiva'); ?></h1>
    <p class="row-top row-md-top aligncenter">
    <?php echo __('Tutto ciò di cui abbiamo bisogno esiste in natura:<br/>i nostri prodotti,
senza additivi chimici o conservanti, garantiscono una sana e corretta alimentazione come la migliore tradizione mediterranea insegna.', 'castadiva'); ?></p>
    <?php else : ?>
    <h1 class="title light"><?= Titles\title(); ?></h1>
    <?php endif; ?>
</div>
<?php else : ?>
<div class="page-header container content row-lg-top row-top">
    <h1 class="title<?php if(get_field('centered')) : ?> aligncenter<?php endif; ?>"><?= Titles\title(); ?></h1>
</div>
<?php endif; ?>
<?php endif; ?>
<?php if(is_home() || is_category() || is_post_type_archive('ricette') || is_tax('recipe_cat')) : ?>
    <nav class="categories-nav">
        <ul class="content row">
            <?php 
            $args = array(
                'show_option_all' => __('Tutte', 'castadiva'),
                'title_li' => false,
                'taxonomy' => (is_post_type_archive('ricette')) ? 'recipe_cat' : 'category'
            );
            wp_list_categories($args); ?>
        </ul>
        <div class="divider-inv"></div>
    </nav>
<?php endif; ?>

<?php get_template_part('templates/search', 'ricette'); ?>
