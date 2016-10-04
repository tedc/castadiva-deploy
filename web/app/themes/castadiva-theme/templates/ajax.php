<article class="news-item-content flx" ng-class="post.post_class">
    <figure class="figure">
        <img ng-src="{{post.post_thumbnail[0]}}" class="img" />
    </figure>
    <div class="post-content">
        <header>
            <span class="news-meta"><?php the_category(', '); ?> <span class="sep">&diams;</span> <time pubdate datetime="<?php the_time('Y:m:d'); ?>"><?php the_time('d F Y'); ?></time></span>
            <h2 class="title news-title">
                <a ng-href="{{post.link}}" ng-bind-title="post.title.rendered"></a>
            </h2>     
        </header>
        <div class="news-summury">
            {{post.exerpt}}
            <a ng-href="{{post.link}}" class="read-more"><?php echo __('Leggi tutto', 'castadiva'); ?></a>
        </div>
    </div>
</article>