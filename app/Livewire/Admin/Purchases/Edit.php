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
        $this->productsCache = Product::whereIn(
            'id',
            collect($this->productList)->pluck('product_id')
        )->get()->keyBy('id');

        $this->purchase = Purchase::with('products.unit')->find($id);

        foreach ($this->purchase->products  as $key => $product) {

            $this->productList[] = [
                'product_id' => $product->id,
                'quantity' => $product->pivot->quantity,
                'price' => $product->pivot->unit_price,
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
        $this->selectedProductId = $id;
        $this->productSearch = Product::find($id)->name;
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



            array_push($this->productList, [
                'product_id' => $this->selectedProductId,
                'quantity' => $this->quantity,
                'price' => $this->price,
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
}
