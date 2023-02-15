<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Products;
use App\Models\Shopping;
use App\Models\Invoice;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $products = Products::get();

        return view('home', [
            'products' => $products,
        ]);
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function buy(Request $request)
    {
        $productId = $request->id;
        $user = Auth::user();
        // $noInvoicedPurchases = $user->noInvoicedPurchases;
        $saveShopping = Shopping::create([
            'user_id' => $user->id,
            'product_id' => $productId,
        ]);

        $saveShopping->saveOrFail();

        // $this->generateInvoice();

        return redirect()->route("home")->with("mensaje", "Compra realizada");
    }


    // public function generateInvoice()
    // {

    // }
}
