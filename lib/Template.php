<?php
require "Smarty.class.php";

function template_page_info() {
    $date = strftime("%c");
    $page_render_time = (float)microtime(true) - (float)$GLOBALS["page_start"];
    $page_render_time = ceil($page_render_time * 1000);
    $out = "Host: {$GLOBALS["cfg"]["host"]} at $date in {$page_render_time}ms";
    return $out;
}

class Template extends Smarty {
    // function display($resource_name, $cache_id = null, $compile_id = null) {
    //     $out = $this->fetch($resource_name, $cache_id, $compile_id, false);
    //     // $out = str_replace('%%PAGE_INFO%%', template_page_info(), $out);
    //     echo $out;
    // }
}