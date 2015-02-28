# cmsms_smartysnippets
Develop new smarty block and functions for complex HTML used in modern themes

### What Does This Do?

Smarty helper functions to assist in complex theme
    implementation.&nbsp; Allows you to define dynamic Smarty snippets that
    can be integrated in your content.

### Usage Instructions:

*   Each snippet is prefixed with "ss_" to avoid naming conflicts
*   Two different types of snippets are supported:

*   Blocks:&nbsp; Requires 2 tags, and open/close, such
            as:&nbsp;&nbsp; {ss_example ...} content inside block {/ss_example}
*   Functions:&nbsp; Single tag with all paramters, such as:&nbsp;
            {ss_glyphicon icon="globe"}Here's a globe*   &nbsp;A snippet should have a single HTML element wrapping your
        content.&nbsp;&nbsp;
*   Attributes:

*   The following parameters become attributes of your tag:

*   Two smarty variables are created from these parameters:*   Smarty Variables:

*   All other parameters are converted to smarty parameters.&nbsp;
            See below for example*   NOTE: In order to support attributes with "-" (such as
        data-target, data-toggle), attribute names using "_" are converted to
        "-".&nbsp; So, your tag may be `{ss_element data_toggle="xxxx"}`,
        which will result in {$attributes} containing `data-toggle="xxxx"`.&nbsp;
        Therefore, I recommend NOT using "_" in your parameters, to simplify
        this process.

### How Does It Work?

#### Block Example:

You may define blocks of HTML code with parameters, such as elements
    from themes.&nbsp; For example, your Block snippet may be a Twitter
    Bootstrap panel, such as:

<div style="margin-left: 40px;">
    <pre>&lt;div {$attributes} class="{$class}"&gt;
    &lt;div class="panel panel-default"&gt;
        &lt;h3 class="page-header"&gt;{$header}&lt;/h3&gt;
        &lt;div class="panel-body"&gt;
            &lt;div class="{$content_class}"&gt;
                {$content}
            &lt;/div&gt;
        &lt;/div&gt;
    &lt;/div&gt;
&lt;/div&gt;</pre>
</div>

Then, in your page, you would use this like so:

<div style="margin-left: 40px;">
    <pre>{ss_panel header="This is my test panel" id="panel_id" class="outer-class" contentclass="content-class"} 
    This is the content of the panel
{/ss_panel}</pre>
</div>

When rendered, your content will be:

<div style="margin-left: 40px;">
    <pre>&lt;div id="panel_id" class="outer-class"&gt;
    &lt;div class="panel panel-default"&gt;
        &lt;h3 class="page-header"&gt;This is my test panel&lt;/h3&gt;
        &lt;div class="panel-body"&gt;
            &lt;div class=""&gt;
                This is the content of the panel
            &lt;/div&gt;
        &lt;/div&gt;
    &lt;/div&gt;
&lt;/div&gt;</pre>
    </div>

#### Function
    Example:
A function is similar, but doesn't require a closing tag.&nbsp; For instance, this is a real snippet from a recent theme:

<div style="margin-left: 40px;">
        <pre>&lt;section class="{$class}" data-stellar-background-ratio="0.5" style="{$style}"&gt;
&nbsp;&nbsp;&nbsp; &lt;div class="container" style="margin-bottom: 50px;"&gt;
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &lt;div class="owl-carousel" data-navigation="false" data-singleitem="false" data-autoplay="true"
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; data-animation="bounceIn"&gt;
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; {foreach $images as $image_root}
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; {assign "image" cms_join_path($directory, $image_root)}
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &lt;div class="item dragCursor"&gt;&lt;img src="{$image}" height="{$height}" alt="..."/&gt;&lt;/div&gt;
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; {/foreach}
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &lt;/div&gt;
&nbsp;&nbsp;&nbsp; &lt;/div&gt;
&lt;/section&gt;
</pre>
</div>
Inserted into the page as such:

<div style="margin-left: 40px;">
    <pre>{ss_carousel images=get_matching_files("uploads/carousel", "png") height="200px" directory="uploads/carousel" class="color parallax" data-stellar-background-ratio="0.5" 
	style="background-image:url(/uploads/theme/assets/images/preview/slider/parallax_bg.jpg)"}</pre>
</div>

### Donations

 [Donations](https://www.paypal.com/cgi-bin/webscr?cmd=_s-xclick&hosted_button_id=TGALC82DKFEJ4) are appreciated, and would encourage continual improvement of this module.




### Support

As per the GPL, this software is provided as-is. Please read the
    text of the license for the full disclaimer.

### Copyright and License

Copyright (c) 2014, Mike Crowe [&lt;drmikecrowe@gmail.com&gt;](mailto:drmikecrowe@gmail.com).
    All Rights Are Reserved.

This module has been released under the [GNU Public
    License](http://www.gnu.org/licenses/licenses.html#GPL).
    You must agree to this license before using the module.
