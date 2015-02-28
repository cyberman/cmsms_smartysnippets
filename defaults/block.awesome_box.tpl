<div{$attributes} class="{$class} serviceColumn animate_from_{$direction}">
    {if $icon gt ''}<i data-animation="rotateIn" class="ico-stack fa fa-{$icon}"></i>{/if}
    <h3 class="page-header">{$header}</h3>
    {$content}
</div>