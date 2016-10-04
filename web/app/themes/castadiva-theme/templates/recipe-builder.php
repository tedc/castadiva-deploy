<?php $products = array(); while(have_rows('recipe_builder')) : the_row();  ?>
    <section class="row row-md recipe-section container">
        <?php if(get_row_layout() == 'first') : ?>
        <div class="content recipe-first-line">
            <?php $cats = wp_get_post_terms( get_the_ID(), 'recipe_cat');
                foreach($cats as $ct){ echo '<a href="'.get_term_link($ct->term_id).'">'.$ct->name.'</a>';}
            ?>
            <span>
                <?php echo __('Difficoltà', 'castadiva'); ?>
                <?php for($i = 1; $i <= 5; $i++) : ?>
                <i class="dot<?php if($i <= get_sub_field('difficulty')): ?> fill<?php endif; ?>"></i>
                <?php endfor; ?>
            </span>
            <span>
                <?php echo __('Preparazione', 'castadiva'); ?>
                <time class="recipe-time"><?php the_sub_field('time'); ?></time>
            </span>
        </div>
        <?php endif; ?>
        <?php if(get_row_layout() == 'intro') : ?>
        <div class="content">
            <?php the_sub_field('testo'); ?>
        </div>
        <?php endif; ?>
        <?php if(get_row_layout() == 'ingriedienti') : ?>
        <div class="content">
            <h2 class="title recipe-title"><?php echo __('Ingredienti', 'castadiva'); ?></h2>
            <p class="sub-title"><?php echo __('Per', 'castadiva'); ?> <?php the_sub_field('persone'); ?> <?php echo __('persone', 'castadiva'); ?></p>
            <ul class="recipe-ingredients row-top row-s-top">
            <?php while(have_rows('ingredienti')) : the_row(); ?>
                <li><p><?php the_sub_field('ingredente'); ?>
                <?php if( get_sub_field('castadiva') ): ?>
                <?php $id = get_sub_field('prodotto_castadiva'); array_push($products, $id);; ?>
                <a href="<?php echo get_permalink($id); ?>" title="<?php echo get_the_title($id); ?>"><?php echo get_the_title($id); ?></a>
                <?php endif; ?></p>
                </li>
            <?php endwhile; ?>
            </ul>
        </div>
        <?php endif; ?>
        <?php if(get_row_layout() == 'foto') : ?>
        <figure class="recipe-figure">
            <img src="<?php the_sub_field('immagine_grande'); ?>" alt="<?php the_title(); ?>" title="<?php the_title(); ?>" class="img" />
        </figure>
        <?php endif; ?>
        <?php if(get_row_layout() == 'preparazione') : ?>
        <h3 class="title recipe-title"><?php echo __('Preparazione', 'castadiva'); ?></h3>
        <div class="content row-top row-lg-top">
            <?php the_sub_field('testo'); ?>
        </div>
        <?php endif; ?>
    </section>
<?php endwhile; ?>
<?php if( !empty($products)) : ?>
<section class="row row-md recipe-section container">
    <h4 class="title recipe-title closing-title">
        <?php echo __('Prodotti utilizzati', 'castadiva'); ?>
    </h4>
    <div class="recipe-products row-top row-lg-top">
    <?php $total = count($products); $q = new WP_Query(
        array(
            'post_type' => 'product',
            'post__in' => $products
        ));
        while($q->have_posts()) : $q->the_post(); ?>
        <div <?php post_class('product-item-more product-item'); ?>>
            <?php get_template_part('templates/content', 'product'); ?>
        </div>
    <?php endwhile; wp_reset_query(); ?>
    </div>
</section>
<?php endif; ?>