<article class="news-item-content flx" ng-class="post.post_class" ng-repeat="post in posts">
    <figure class="figure">
        <img ng-src="{{post.post_thumbnail[0]}}" class="img" />
    </figure>
    <div class="post-content">
        <header>
            <span class="news-meta"><span ng-bind-html="post.post_cat"></span> <span class="sep">&diams;</span> <time pubdate ng-bind-html="(post.date | date : format : 'dd MM YYY')"></time></span>
            <h2 class="title news-title">
                <a ng-href="{{post.link}}" ng-bind-title="post.title.rendered"></a>
            </h2>     
        </header>
        <div class="news-summury" ng-bind-html="post.excerpt.rendered">
        </div>
        <a ng-href="{{post.link}}" class="read-more"><?php echo __('Leggi tutto', 'castadiva'); ?></a>
    </div>
</article>