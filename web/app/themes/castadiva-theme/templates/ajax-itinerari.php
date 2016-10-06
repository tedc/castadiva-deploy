<article ng-class="post.post_class" id="tour_{{post.id}}" ng-repeat="post in posts">
    <figure class="tour-figure">
        <img ng-src="{{post.post_thumbnail}}" />
    </figure>
    <div class="tour-content-single row-top row-md-top">
        <h2 class="title">
            <a ng-href="{{post.link}}" ng-bind-html="{{post.title.rendered}}"></a>
        </h2>
        <div class="row-top row-md-top">
        {{post.excerpt.rendered}}
        <a ng-href="{{post.link}}" class="btn">
            <span class="btn-text"><?php echo __('Scopri', 'castadiva'); ?></span>
        </a>
        </div>
    </div>
    <figure class="diamond" ng-sm from="{y: '100%'}" to="{y: '-100%'}" duration="200%" offset="-100" trigger-hook="onEnter" trigger-element="#tour_{{post.id}}">
        <img ng-src="{{post.post_thumbnail}}" class="img" />
    </figure>
</article>