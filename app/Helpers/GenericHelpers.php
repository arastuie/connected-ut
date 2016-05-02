<?php

/**
 * Makes session flash
 *
 * @param $type
 * @param $title
 * @param $message
 */
function flash($type, $title = '', $message = '')
{
    session()->flash('flash_type', $type);
    session()->flash('flash_title', $title);
    session()->flash('flash_message', $message);
}