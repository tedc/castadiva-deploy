<article class="news-item-content flx" ng-class="post.post_class" >
    <figure class="recipe-figure">
        <div class="diamond">
            <img ng-src="{{post.post_thumbnail[0]}}" class="img" />
        </div>
    </figure>
    <div class="post-content">
        <header>
            {{post.post_cat | html}}
            <h2 class="title news-title">
                <a ng-href="{{post.link}}" ng-bind-title="post.title.rendered"></a>
            </h2>
            <div class="recipe-first-line" ng-repeat="item as post.acf.recipe_builder | filter: q as results" ng-init="q = 'first'">
               <span>
                    <?php echo __('Difficoltà', 'castadiva'); ?>
                    <i class="dot" ng-repeat="i in [1,2,3,4,5]" ng-class="{fill : i <= item.difficulty}"></i>
                    <?php for($i = 1; $i <= 5; $i++) : ?>
                </span>
                <span>
                    <?php echo __('Preparazione', 'castadiva'); ?>
                    <time class="recipe-time" ng-bind-html="item.time"></time>
                </span>
            </div>
        </header>
        <div class="news-summury">
            {{post.exerpt | html}}
            <a ng-href="{{post.link}}" class="read-more"><?php echo __('Leggi tutto', 'castadiva'); ?></a>
        </div>
    </div>
</article>