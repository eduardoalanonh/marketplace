<?php

namespace App\Http\Controllers;

use App\Product;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    private $product;

    public function __construct(Product $product)
    {
        $this->product = $product;
    }


    public function index()
    {
        $products = $this->product->limit(9)->orderBy('id', 'DESC')->get();

        return view('welcome', compact('products'));
    }

    public function single($slug)
    {
            $product = $this->product->whereSlug($slug)->first();

            return view('single', compact('product'));
    }
}
