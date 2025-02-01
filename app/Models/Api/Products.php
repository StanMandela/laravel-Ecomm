<?php

namespace App\Models\Api;

class Products extends \App\Models\Products
{
    public function getRouteKey()
    {
        return 'id';
    }
}