<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Product;

class ProductController extends Controller
{
    const IMG_URL_BASE = 'http://testurl.com/images/';

    function index()
    {
        // Get all products
        $products = Product::all();

        foreach ($products as $product) {
            $product->img_front = self::IMG_URL_BASE . $product->img_front;
            $product->img_side = self::IMG_URL_BASE . $product->img_side;
            $product->img_back = self::IMG_URL_BASE . $product->img_back;
        }

        // Render view
        return view('products/index', $data = [
            'products' => $products,
            'imgUrlBase' => self::IMG_URL_BASE,
        ]);
    }
}
