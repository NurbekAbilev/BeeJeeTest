<?php

function base_path($path)
{
    return __DIR__ . $path;
}

function dd($var)
{
    print_r($var);die;
}