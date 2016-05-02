<?php

namespace App\Contracts;

interface ISearch
{
    public function on($index);

    public function get();
}