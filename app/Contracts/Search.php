<?php

namespace App\Contracts;

interface Search
{
    public function on($index);

    public function get();
}