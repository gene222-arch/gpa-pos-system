<?php

    if (! function_exists('activeSegment') ) {

        function activeSegment ($name, $segment = 2, $class = 'active') 
        {   
            return request()->segment($segment) == $name ? $class : '';
        }   
    }       

    if (! function_exists('currencySymbol') )
    {
        function currencySymbol()
        {
            if (config('settings.currency_symbol') == '$') {
                return 'fas fa-dollar-sign';
            } 
            if (config('settings.currency_symbol') == 'P') {
                return 'fab fa-product-hunt';
            } 
        }
    }


/**
 * localhost/admin/products
 * request()->segment(2) === products
 * request()->segment(1) === admin 
 */