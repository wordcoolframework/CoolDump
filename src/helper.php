<?php

use CoolDump\CoolDump;

if (!function_exists('wc')){
    function wc(...$data) : void {
        $wtf = new CoolDump();
        $wtf->wc(...$data);
    }
}

if(!function_exists('wcJson')){
    function wcJson(...$data) : void{
        $wtf = new CoolDump();
        $wtf->wcJson(...$data);
    }
}