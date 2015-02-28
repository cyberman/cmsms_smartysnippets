<?php

function smarty_modifier_resmarty($string) {
    Resmarty::process($string);
}
