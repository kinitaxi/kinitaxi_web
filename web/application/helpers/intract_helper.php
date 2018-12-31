<?php defined('BASEPATH') OR exit('No direct script access allowed');

function base_url($atRoot=FALSE, $atCore=FALSE, $parse=FALSE)
{ //set my base_url to assets folder
    if (isset($_SERVER['HTTP_HOST'])) {
        $http = isset($_SERVER['HTTPS']) && strtolower($_SERVER['HTTPS']) !== 'off' ? 'https' : 'http';
        $hostname = $_SERVER['HTTP_HOST'];
        $dir = str_replace(basename($_SERVER['SCRIPT_NAME']), 'public/assets/', $_SERVER['SCRIPT_NAME']);

        $core = preg_split('@/@', str_replace($_SERVER['DOCUMENT_ROOT'], '', realpath(dirname(__FILE__))), NULL, PREG_SPLIT_NO_EMPTY);
        $core = $core[0];

        $tmplt = $atRoot ? ($atCore ? "%s://%s/%s/" : "%s://%s/") : ($atCore ? "%s://%s/%s/" : "%s://%s%s");
        $end = $atRoot ? ($atCore ? $core : $hostname) : ($atCore ? $core : $dir);
        $base_url = sprintf($tmplt, $http, $hostname, $end);
    } else $base_url = 'http://localhost/';

    if ($parse) {
        $base_url = parse_url($base_url);
        if (isset($base_url['path'])) if ($base_url['path'] == '/') $base_url['path'] = '/';
    }

    return $base_url;
}
function site_url($link = '')
{
    //set my site_url to assets folder
    if (isset($_SERVER['HTTP_HOST'])) {
        $link = str_replace("public/assets/","", base_url()).$link;
    }
    return $link;
}

if ( ! function_exists('csrf_token')) {
    function csrf_token($option)
    {
        $CI =& get_instance();
        if (isset($option) && $option == 'name')
            return $CI->security->get_csrf_token_name();
        if (isset($option) && $option == 'value')
            return $CI->security->get_csrf_hash();
    }
}
if ( ! function_exists('timeAgo')) {
     function timeAgo($time_ago)
        {
            $time_ago = strtotime(date('Y-m-d H:i:s', $time_ago));
            $cur_time   = time();
            $time_elapsed   = ($cur_time - $time_ago)+3600;
            $seconds    = $time_elapsed ;
            $minutes    = round($time_elapsed / 60 );
            $hours      = round($time_elapsed / 3600);
            $days       = round($time_elapsed / 86400 );
            $weeks      = round($time_elapsed / 604800);
            $months     = round($time_elapsed / 2600640 );
            $years      = round($time_elapsed / 31207680 );

            // Seconds
            if($seconds <= 60){
                return "Just now";
            }
            //Minutes
            else if($minutes <=60){
                if($minutes==1){
                    return "One minute ago";
                }
                else{
                    return "$minutes minutes ago";
                }
            }
            //Hours
            else if($hours <=24){
                if($hours==1){
                    return "An hour ago";
                }else{
                    return "$hours hrs ago";
                }
            }
            //Days
            else if($days <= 7){
                if($days==1){
                    return "Yesterday";
                }else{
                    return "$days days ago";
                }
            }
            //Weeks
            else if($weeks <= 4.3){
                if($weeks==1){
                    return "A week ago";
                }else{
                    return "$weeks weeks ago";
                }
            }
            //Months
            else if($months <=12){
                if($months==1){
                    return "A month ago";
                }else{
                    return "$months months ago";
                }
            }
            //Years
            else{
                if($years==1){
                    return "One year ago";
                }else{
                    return "$years years ago";
                }
            }

    }
}
if ( ! function_exists('random')) {
    function random($array=[])
    {
        return array_rand($array, 1);
    }
}
if ( ! function_exists('retrieve_first')) {
    function retrieve_first($text)
    {
        return substr($text, 0, 1);
    }
}
if ( ! function_exists('ccMasking')) {
    function ccMasking($number, $maskingCharacter = '*') {
        return substr($number, 0, 4) . str_repeat($maskingCharacter, strlen($number) - 8) . substr($number, -4);
    }
}
