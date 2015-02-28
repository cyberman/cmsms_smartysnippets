<?php
/**
 * Created by PhpStorm.
 * User: mcrowe
 * Date: 9/9/14
 * Time: 7:43 AM
 */

class sshelper
{
    public static function stripp($string) {
        if ( is_string($string) ) {
            $search = ["<p>{", "}</p>","<p><div","</div></p>","<p><section","</section></p>"];
            $replace = ["{", "}","<div","</div>","<section","</section>"];
            return str_replace($search, $replace, $string);
        }
        return $string;
    }

    public static function resmarty($string) {
        $smarty = cms_utils::get_smarty();
        return $smarty->fetch("string:$string");
    }

    public static function smarty_vars()
    {
        $smarty = cms_utils::get_smarty();
        return $smarty->get_template_vars();
    }



    public static function firstelement($string) {
        try {
            $doc = new DOMDocument();
            @$doc->loadHTML("<html><body>$string</body></html>");
            $body = $doc->getElementsByTagName('body')->item(0);
            foreach ( $body->childNodes as $node ) {
                $res = $doc->saveHTML($node);
                if ( strlen($res) > 10 ) {
                    if ( count($node->childNodes) == 1 && $node->tagName == "p" ) {
                        $new = $doc->saveHTML($node->firstChild);
                        break;
                    } else {
                        $new = preg_replace('/^<!DOCTYPE.+?>/', '', str_replace( array('<html>', '</html>', '<body>', '</body>'), array('', '', '', ''), $doc->saveHTML($node->firstChild)));
                        break;
                    }

                }
            }
        } catch ( Exception $e ) {
        }
        if ( strlen($new) > 10 ) {
            return $new;
        }
        return $string;
    }

}