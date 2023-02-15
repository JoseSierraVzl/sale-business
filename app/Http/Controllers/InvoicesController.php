<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Shopping;
use App\Models\Products;
use App\Models\Invoice;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class InvoicesController extends Controller
{
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function list()
    {
        $unbilledPurchases = $this->getUnbilledPurchases();
        $invoicedPurchases = $this->getInvoicedPurchases();

        return view('pages.list-invoices', [
            'unbilledPurchases' => $unbilledPurchases,
            'invoicedPurchases' => $invoicedPurchases,
        ]);
    }

    public function getInvoicedPurchases()
    {
        $users = $this->getAllUsers();

        $invoicedPurchases = array_filter($users, function($user) {
            $shoppings = Shopping::where('user_id', $user->id)->get();

            if (
                count($shoppings->all()) > 0 &&
                count($this->ifInvoiced($shoppings->all())) !== 0 &&
                $user->role !== 'admin'
            ) {
                return $user;
            }
        });

        return $this->getInvoicesProcessed($invoicedPurchases);        
    }

    public function getUnbilledPurchases()
    {
        $users = $this->getAllUsers();

        $unbilledPurchases = array_filter($users, function($user) {
            if (
                count($user->noInvoicedPurchases->all()) > 0 &&
                $user->role !== 'admin'
            ) {
                return $user;
            }
        });

        return $this->getInvoicesPending($unbilledPurchases);
    }

    public function ifInvoiced(array $shoppings)
    {
        return array_filter($shoppings, function($shopping) {
            if ($shopping->invoice_id) {
                return $shopping;
            }
        });
    }

    public function notInvoiced(array $shoppings)
    {
        return array_filter($shoppings, function($shopping) {
            if (!$shopping->invoice_id) {
                return $shopping;
            }
        });
    }

    public function getLastInvoiced(array $shoppings)
    {
        return $shoppings[count($shoppings) - 1];
    }

    public function getAllUsers()
    {
        $user = Auth::user();

        return $user->get()->all();
    }

    public function getInvoicesProcessed(array $purchases)
    {
        return array_map(function($purchase) {
            $shoppings = $this->getLastInvoiced($purchase->shoppings->all());
            $products = $this->getProducts([$shoppings]);

            return [
                'userId' => $purchase->id,
                'name' => $purchase->name,
                'amountTotal' => $this->getAmountTotal($products),
                'taxsTotal' => $this->getTaxsTotal($products),
                'products' => $products,
            ];

        }, $purchases);       
    }

    public function getInvoicesPending(array $purchases)
    {
        return array_map(function($purchase) {
            $shoppings = $this->notInvoiced($purchase->shoppings->all());
            $products = $this->getProducts($shoppings);

            return [
                'userId' => $purchase->id,
                'name' => $purchase->name,
                'amountTotal' => $this->getAmountTotal($products),
                'taxsTotal' => $this->getTaxsTotal($products),
                'products' => $products,
            ];

        }, $purchases);
    }

    public function getProducts(array $shoppings)
    {
        return array_map(function($shopping) {
            return Products::where('id', $shopping->product_id)
                ->orderBy('created_at')
                ->get()
                ->all();
        }, $shoppings);
    }

    public function getAmountTotal(array $products)
    {
        $prices = array_map(function($product) {
            return $product[0]->price;
        }, $products);

        return array_sum(array_values($prices));
    }

    public function getTaxsTotal(array $products)
    {
        $taxs = array_map(function($product) {
            return $product[0]->tax;
        }, $products);

        return array_sum(array_values($taxs));
    }

    public function updateShoppings(int $invoiceId, int $userId)
    {
        $shoppings = Shopping::where('user_id', $userId)->get()->all();

        array_walk($shoppings, function($shopping) use ($invoiceId) {
            Shopping::where('id', $shopping->id)->update(
                ['invoice_id' => $invoiceId]
            );
        });
    }

    public function create(Request $request)
    {
        $userId = $request->id;
        $shoppings = Shopping::where('user_id', $userId)->get();
        $products = $this->getProducts($shoppings->all());

        $invoice = Invoice::create([
            'user_id' => $userId,
            'sub_total' => $this->getAmountTotal($products),
            'taxs_total' => $this->getTaxsTotal($products),
        ]);

        $this->updateShoppings($invoice->id, $userId);

        return redirect()->route("home")->with("mensaje", "Factura realizada");
    }
}
