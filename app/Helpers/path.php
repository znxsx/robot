<?php
if ( ! function_exists('node_module_path'))
{
    function node_module_path()
    {
        return d('path.node_modules') . SLASH;
    }
} else dd('function node_module_path exists.' . __FILE__ . ':' . __LINE__);

if ( ! function_exists('app_public_url'))
{
    function app_public_url()
    {
        return A . SLASH;
    }
} else dd('function app_public_url exists.' . __FILE__ . ':' . __LINE__);

if ( ! function_exists('base_url'))
{
    function base_url()
    {
        return URL::to('/') . SLASH;
    }
} else dd('function base_url exists.' . __FILE__ . ':' . __LINE__);

if ( ! function_exists('A'))
{
    function A()
    {
        return cons('A');
    }
} else dd('function A exists.' . __FILE__ . ':' . __LINE__);

if ( ! function_exists('captcha_path'))
{
    function captcha_path()
    {
        return cons('A') . SLASH . 'img' . SLASH . 'captcha' . SLASH;
    }
} else dd('function captcha_path exists.' . __FILE__ . ':' . __LINE__);

if ( ! function_exists('captcha_expired_time'))
{
    function captcha_expired_time($minute=1)
    {
        return cons('CAPTCHA_EXPIRED_TIME');
    }
} else dd('function captcha_expired_time exists.' . __FILE__ . ':' . __LINE__);

