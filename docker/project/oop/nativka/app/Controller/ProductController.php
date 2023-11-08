<?php

namespace Controllers;

use Models\Product;
use Src\View;

class ProductController
{
    public function index(): void
    {
        $posts = Product::all()->toArray();

        (new View())->toJSON($posts);
    }
}