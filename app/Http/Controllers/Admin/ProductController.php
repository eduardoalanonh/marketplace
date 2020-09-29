<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Product;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\View\View;
use App\Http\Requests\ProductRequest;
use App\traits\UploadTrait;

class ProductController extends Controller
{
    use UploadTrait;

    private $product;

    public function __construct(Product $product)
    {
        $this->product = $product;
    }

    /**
     * Display a listing of the resource.
     *
     * @return Application|Factory|Response|View
     */
    public function index()
    {
        $user = auth()->user();

        if (!$user->store()->exists()) {
            flash('eh preciso criar uma loja para cadastrar produtos')->warning();
            return redirect()->route('admin.stores.index');
        }
        $products = $user->store->products()->paginate(10);

        return view('admin.products.index', compact('products'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Application|Factory|Response|View
     */
    public function create()
    {
        $categories = \App\Category::all(['id', 'name']);

        return view('admin.products.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param ProductRequest $request
     * @return Response
     */
    public function store(ProductRequest $request)
    {

        $data = $request->all();
        $data['price'] = formatPriceToDataBase($data['price']);

        $categories = $request->get('categories', null);

        $store = auth()->user()->store;
        $product = $store->products()->create($data);
        $product->categories()->sync($categories);

        if ($request->hasFile('photos')) {

            $images = $this->imageUpload($request->file('photos'), 'image');

            //insercao images
            $product->photos()->createMany($images);
        }

        flash('Produto criado com sucesso!')->success();
        return redirect()->route('admin.products.index');
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return Response
     */
    public function show($id)
    {

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param $product
     * @return Application|Factory|Response|View
     */
    public function edit($product)
    {

        $product = $this->product->findOrfail($product);
        $categories = \App\Category::all(['id', 'name']);
        return view('admin.products.edit', compact('product', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param ProductRequest $request
     * @param $product
     */
    public function update(ProductRequest $request, $product)
    {
        $data = $request->all();
        $categories = $request->get('categories', null);

        $product = $this->product->find($product);

        $product->update($data);

        if ($categories) {
            $product->categories()->sync($categories);
        }

        if ($request->hasFile('photos')) {

            $images = $this->imageUpload($request->file('photos'), 'image');

            //insercao images
            $product->photos()->createMany($images);
        }


        flash('Produto atualizado com sucesso!')->success();
        return redirect()->route('admin.products.index');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $product
     * @return Response
     */
    public function destroy($product)
    {

        $product = $this->product->find($product);
        $product->delete();

        flash('Produto removido com sucesso!')->overlay('oi', 'teste');
        return redirect()->route('admin.products.index');
    }

}
