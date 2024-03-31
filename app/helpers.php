<?php
use Illuminate\Support\Facades\Auth;

if (!function_exists("getUser")) {
    function getUser()
    {
        return Auth::user();
    }
}
if (!function_exists('getFormattedDate')) {
    function getFormattedDate($format, $date)
    {
        return $date != null ? date($format, strtotime($date)) : '';
    }
}


if (!function_exists("getConstants")) {
    function getConstants($class)
    {
        return (new ReflectionClass($class))->getConstants();
    }
}