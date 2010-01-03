<?php
/**
 * Smarty plugin
 * @package Smarty
 * @subpackage plugins
 */


/**
 * Smarty count_characters modifier plugin
 *
 * Type:     modifier<br>
 * Name:     wordify_seconds<br>
 * Purpose:  turns seconds to something like "about 10 minutes ago"
 * @param integer
 * @return string
 */
function smarty_modifier_wordify_seconds($integer, $now_threshold = 1) {
    $words[1]               = " second";
    $words[60]              = " minute";
    $words[3600]            = " hour";
    $words[86400]           = " day";
    $words[604800]          = " week";
    $words[2629744]         = " month";

    foreach($words as $div => $str) {
        if ($integer >= $div) {
            $string = "";
            $res = $integer / $div;

            if ($res != floor($res)) {
                $string = "about ";
            }

            $res = floor($res);
            if ($res == 1) 
                $res = (preg_match("/^ (a|e|i|o|u|ho)/", $str)) ? "an" : "a";
            else
                $str .= "s";
            $string .= $res . $str;
        }
        if ($integer < $div) {
            break;
        }
    }

    if ($integer >= $now_threshold) {
        $string .= " ago";
    }
    elseif ($integer < 0) {
        $string .= " in the future";
    }
    else {
        $string = "right now";
    }

    return $string;
}

