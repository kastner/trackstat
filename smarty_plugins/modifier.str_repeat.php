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
 * Name:     str_repeat<br>
 * Purpose:  turns seconds to something like "about 10 minutes ago"
 * @param integer
 * @return string
 */
function smarty_modifier_str_repeat($string, $times) {
    return str_repeat($string, $times);
}

