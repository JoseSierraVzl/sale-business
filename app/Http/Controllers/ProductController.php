<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Products;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('pages.product-create');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = $request->all();

        $saveProducts = Products::create([
            'name' => $data['name'],
            'price' => $data['price'],
            'tax' => $data['tax'],
        ]);

        $saveProducts->saveOrFail();

        return redirect()->route("home")->with("mensaje", "Producto guardado");
    }
}
