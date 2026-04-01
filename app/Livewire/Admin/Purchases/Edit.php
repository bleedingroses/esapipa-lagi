<?php

namespace App\Livewire\Admin\Purchases;

use App\Models\Product;
use App\Models\Purchase;
use App\Models\Supplier;
use Livewire\Component;

class Edit extends Component
{
    public $supplierSearch;
    public $productSearch;
    public $selectedProductId;
    public $quantity;
    public $price;
    public Purchase $purchase;
    public $tax = 0;
    public $productList = [];
    public $productsCache = [];



    function rules()
    {
        return [
            'purchase.purchase_date' => 'required',
            'purchase.supplier_id' => 'required',
        ];
    }


    function mount($id)
    {

        $this->purchase = Purchase::with('products.unit')->findOrFail($id);

        //ambil tax dari DB
        $this->tax = $this->purchase->tax_percentage;

        //isi ulang productList dari pivot
        foreach ($this->purchase->products as $product) {

            $this->productList[] = [
                'product_id' => $product->id,
                'product_name' => $product->name,
                'unit_name' => $product->unit->name,

                'quantity' => $product->pivot->quantity,
                'price' => $product->pivot->unit_price,

                //optional (kalau mmau tampil diskon lama)
                'original_price' => $product->purchase_price,
                'discount' => 0, //kalau belum simpan diskon di DB
            ];
            //cache product
            $this->productsCache[$product->id] = $product;
        }
        $this->supplierSearch = $this->purchase->supplier->name;
    }

    function deleteCartItem($key)
    {
        array_splice($this->productList, $key, 1);

        $this->productsCache = Product::whereIn(
            'id',
            collect($this->productList)->pluck('product_id')
        )->get()->keyBy('id');
    }

    function addQuantity($key)
    {
        $this->productList[$key]['quantity']++;
    }
    function subtractQuantity($key)
    {
        $this->productList[$key]['quantity']--;
    }


    function selectSupplier($id)
    {
        $this->purchase->supplier_id = $id;

        $supplier = Supplier::find($id);
        $this->supplierSearch = $supplier?->name;

    }
    function selectProduct($id)
    {
        $product = Product::find($id);

        if (!$product) return;

        $this->selectedProductId = $product->id;
        $this->productSearch = $product->name;
        $this->price = $product->purchase_price;
    }
    function addToList()
    {
        try {
            $this->validate([
                'selectedProductId' => 'required|exists:products,id',
                'quantity' => 'required|numeric|min:1',
                'price' => 'required|numeric|min:0',
            ]);

            foreach ($this->productList as $key => $listItem) {
                if ($listItem['product_id'] == $this->selectedProductId && $listItem['price'] == $this->price) {
                    $this->productList[$key]['quantity'] += $this->quantity;
                    return;
                }
            }


            $product = Product::find($this->selectedProductId);

            array_push($this->productList, [
                'product_id' => $product->id,
                'product_name' => $product->name,
                'unit_name' => $product->unit->name,

                'quantity' => $this->quantity,
                'price' => $this->price,

                'original_price' => $product->purchase_price,
                'discount' => 0,
            ]);

            $this->reset([
                'productSearch',
                'selectedProductId',
                'quantity',
                'price',
            ]);
        } catch (\Throwable $th) {
            $this->dispatch('done', error: "Something Went Wrong: " . $th->getMessage());
        }

        $this->productsCache[$this->selectedProductId] = Product::find($this->selectedProductId);
        $this->productsCache = Product::whereIn(
            'id',
            collect($this->productList)->pluck('product_id')
        )->get()->keyBy('id');
    }

    function makePurchase()
    {   
        if (empty($this->productList)) {
            return $this->dispatch('done', error: 'Produk tidak boleh kosong');
        }
        
        try {
            $this->validate();

            //update file utama
            $this->purchase->update([
                'purchase_date' => $this->purchase->purchase_date,
                'supplier_id' => $this->purchase->supplier_id,

                'subtotal' => $this->subtotal,
                'tax_percentage' => $this->tax,
                'tax_amount' => $this->taxAmount,
                'grand_total' => $this->grandTotal,
            ]);

            //reset relasi
            $this->purchase->products()->detach();

            //attach ulang
            foreach ($this->productList as $listItem) {
                $this->purchase->products()->attach($listItem['product_id'], [
                    'quantity' => $listItem['quantity'],
                    'unit_price' => $listItem['price'],
                ]);
            }
            return redirect()->route('admin.purchases.index');
        } catch (\Throwable $th) {
            $this->dispatch('done', error: "Something Went Wrong: " . $th->getMessage());
        }
    }
    public function render()
    {
        $suppliers = $this->supplierSearch
        ? Supplier::where('name', 'like', '%' . $this->supplierSearch . '%')->get()
        : [];
        
        $products = [];

        if ($this->productSearch) {
            $products = Product::where('name', 'like', '%' . $this->productSearch . '%')
                ->limit(5)    
                ->get();
        }

        return view('livewire.admin.purchases.edit', [
            'suppliers' => $suppliers,
            'products' => $products,
        ]);
    }
        public function getSubtotalProperty()
    {
        return collect($this->productList)->sum(function ($item) {
            return $item['quantity'] * $item['price'];
        });
    }

    public function getTaxAmountProperty()
    {
        return (float) $this->subtotal * ((float) $this->tax / 100);

    }

    public function getGrandTotalProperty()
    {
        return (float) $this->subtotal + (float) $this->taxAmount;
    }
}
