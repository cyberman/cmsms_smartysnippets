<section class="{$class}" data-stellar-background-ratio="0.5" style="{$style}">
    <div class="container" style="margin-bottom: 50px;">
        <div class="owl-carousel" data-navigation="false" data-singleitem="false" data-autoplay="true"
             data-animation="bounceIn">
            {foreach $images as $image_root}
                {assign "image" cms_join_path($directory, $image_root)}
                <div class="item dragCursor"><img src="{$image}" height="{$height}" alt="..."/></div>
            {/foreach}
        </div>
    </div>
</section>
