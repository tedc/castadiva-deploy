<li class="col-1 ajax-product product-show-more produc-item" ng-class="post.post_class" ng-sm from="{y : '20%', opacity: 0, ease: Back.easeOut.config(1.7)}" trigger-hook="1" speed="1" ng-repeat="post in posts">
    <div class="offset">
        <figure ng-bind-html="post.product_attrs.thumb"></figure>
        <div class="product-more">
        <div class="pattern"></div>
        <a ng-href="{{post.link}}" class="btn">
            <span class="btn-text"><?php echo __('Guarda', 'castadiva'); ?></span>
        </a>
        </div>
    </div>
<div class="offset row row-md">
    <span class="onsale" ng-if="post.product_attrs.onsale"><?php echo __('Offerta', 'castadiva'); ?></span>
    <h3 class="title" ng-bind-html="post.title.rendered"></h3>
    <div class="description light upper" ng-if="post.product_attrs.desc" ng-bind-html="post.product_attrs.desc">
    </div>
    <span class="light upper attribute" ng-if="post.product_attrs.weight" ng-bind-html="post.product_attrs.weight"></span>
    <span class="light upper attribute" ng-repeat="attr in post.product_attrs.attributes">
        {{attr.value}} {{attr.name}}
    </span>
    <p class="price" ng-bind-html="post.product_attrs.price" ng-class="{discount : post.product_attrs.onsale}"></p>  
</div>
<a class="permalink" ng-href="{{post.link}}"></a>
</li>