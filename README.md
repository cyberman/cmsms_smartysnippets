# cmsms_smartysnippets
Develop new smarty block and functions for complex HTML used in modern themes

### What Does This Do?

Smarty helper functions to assist in complex theme implementation.&nbsp; Allows you to define dynamic Smarty snippets that can be integrated in your content.  Best of all, these snippets are TinyMCE compatible, so you can enter complex HTML inside page content and not loose attributes.

### Usage Instructions:

*   Each snippet is prefixed with "ss_" to avoid naming conflicts
*   Two different types of snippets are supported:

*   Blocks:&nbsp; Requires 2 tags, and open/close, such as:

    ````{ss_example ...} content inside block {/ss_example}    ````

*   Functions:&nbsp; Single tag with all paramters, such as:

    ````            {ss_glyphicon icon="globe"}Here's a globe    ````

*   A snippet should have a single HTML element wrapping your content.  For example, make sure that your top-level HTML attribute wraps your contact in something like:

    ````    <div...> your template </div>````

*   Attributes:  The following parameters become attributes of your tag:

  *  'id', 'name', 'autocomplete', 'autocorrect', 'autofocus',  'autosuggest', 'checked', 'dirname', 'disabled', 'tabindex', 'list',  'max', 'maxlength', 'min', 'multiple', 'novalidate', 'pattern',  'placeholder', 'readonly', 'required', 'size', 'step', 'data\_target', 'data\_toggle'

*   Two smarty variables are created from these parameters:

  *   {$attributes} -- All the parameters above, concatenated into a single string
  *   {$attributes_without_id} -- Same as above, but without the id (useful when you insert your id manually)

*   Smarty Variables:

*   All other parameters are converted to smarty parameters. See below for examples
  *   NOTE: In order to support attributes with "-" (such as data-target, data-toggle), attribute names using "\_" are converted to "-".&nbsp; So, your tag may be `{ss_element data_toggle="xxxx"}`, which will result in {$attributes} containing `data-toggle="xxxx"`.&nbsp; Therefore, I recommend NOT using "\_" in your parameters, to simplify this process.
### How Does It Work?

#### Block Example:

You may define blocks of HTML code with parameters, such as elements
    from themes.&nbsp; For example, your Block snippet may be a Twitter
    Bootstrap panel, such as:

``` HTML
<div {$attributes} class="{$class}">
    <div class="panel panel-default">
        <h3 class="page-header">{$header}</h3>
        <div class="panel-body">
            <div class="{$content_class}">
                {$content}
            </div>
        </div>
    </div>
</div>
```

Then, in your page, you would use this like so:

``` HTML
{ss_panel header="This is my test panel" id="panel_id" class="outer-class" contentclass="content-class"}
    This is the content of the panel
{/ss_panel}
```

When rendered, your content will be:

``` HTML
<div id="panel_id" class="outer-class">
    <div class="panel panel-default">
        <h3 class="page-header">This is my test panel</h3>
        <div class="panel-body">
            <div class="">
                This is the content of the panel
            </div>
        </div>
    </div>
</div>
```

#### Function Example:
A function is similar, but doesn't require a closing tag.&nbsp; For instance, this is a real snippet from a recent theme:

``` HTML
<section class="{$class}" data-stellar-background-ratio="0.5" style="{$style}">
    <div class="container" style="margin-bottom: 50px;">
        <div class="owl-carousel" data-navigation="false" data-singleitem="false" data-autoplay="true" data-animation="bounceIn">
            {foreach $images as $image_root}
                {assign "image" cms_join_path($directory, $image_root)}
                <div class="item dragCursor"><img src="{$image}" height="{$height}" alt="..."/></div>
            {/foreach}
        </div>
    </div>
</section>
```

Inserted into the page as such:

``` HTML
{ss_carousel images=get_matching_files("uploads/carousel", "png") height="200px" directory="uploads/carousel" class="color parallax" data-stellar-background-ratio="0.5"
    style="background-image:url(/uploads/theme/assets/images/preview/slider/parallax_bg.jpg)"}
```

### Included Blocks

* block.row.tpl -- Creates a bootstrap row, such as ```{ss_row}.....{/ss_row}```
* block.column.tpl -- Creates a bootstrap column, such as ```{ss_column}.....{/ss_column}```
* block.div.tpl -- Generic div block.  Used when you need to create a hidden div, or something.
* block.panel.tpl -- [Bootstrap panel](http://bootstrapdocs.com/v3.2.0/docs/components/#panels) example
* block.section.tpl -- [HTML5 Section block](https://developer.mozilla.org/en-US/docs/Web/HTML/Element/section) (seems to be prevalent in many new themes).  This shows how to take an HTML block from your newly purchased theme and convert it into a generic tag
* function.carousel.tpl -- Embed [Owl Carousel](http://owlgraphic.com/owlcarousel/) in a page and show all images in a specific image directory in the carousel
* function.glyphicon.tpl -- Quickly embed a [Glyphicon](http://glyphicons.com/)


### Donations

 [Donations](https://www.paypal.com/cgi-bin/webscr?cmd=_s-xclick&hosted_button_id=TGALC82DKFEJ4) are appreciated, and would encourage continual improvement of this module.




### Support

As per the GPL, this software is provided as-is. Please read the
    text of the license for the full disclaimer.

### Copyright and License

Copyright (c) 2015, Mike Crowe [&lt;drmikecrowe@gmail.com&gt;](mailto:drmikecrowe@gmail.com).
    All Rights Are Reserved.

This module has been released under the [GNU Public
    License](http://www.gnu.org/licenses/licenses.html#GPL).
    You must agree to this license before using the module.
