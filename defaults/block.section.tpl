<section id="{$id}" {$attributes_without_id} class="{$class}">
    {if $header gt ''}<header>
        <h2 data-animation="bounceIn" class="animated bounceIn">{$header}</h2>
        {if $subheader gt ''}<h3>{$subheader}</h3>{/if}
    </header>{/if}
    <article class="container ">
        <div class="serviceBoxContainer {$content_class}">
            {$content}
        </div>
    </article>
</section>