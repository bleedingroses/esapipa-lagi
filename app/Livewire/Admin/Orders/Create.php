<?php

namespace App\Livewire\Admin\Orders;

use App\Models\Order;
use App\Models\Product;
use App\Models\Supplier;
use Livewire\Component;

class Create extends Component
{
    public $supplierSearch;
    public $productSearch;
    public $selectedProductId;
    public $quantity;
    public $notes = '';
    public Order $order;

    public $productList = [];



    function rules()
    {
        return [
            'order.order_date' => 'required',
            'order.supplier_id' => 'required',
            'order.notes' => 'nullable|string',
        ];
    }


    function mount()
    {
        $this->order = new Order();
    }

    function deleteCartItem($key)
    {
        array_splice($this->productList, $key, 1);
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
        $this->order->supplier_id = $id;
        $this->supplierSearch = $this->order->supplier->name;

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
                'selectedProductId' => 'required',
                'quantity' => 'required',
            ]);

            foreach ($this->productList as $key => $listItem) {
                if ($listItem['product_id'] == $this->selectedProductId) {
                    $this->productList[$key]['quantity'] += $this->quantity;
                    return;
                }
            }



            array_push($this->productList, [
                'product_id' => $this->selectedProductId,
                'quantity' => $this->quantity,
                'price' => 0, // Set default price to 0 since not used
                'notes' => $this->notes,
            ]);

            $this->reset([
                'productSearch',
                'selectedProductId',
                'quantity',
                'notes',
            ]);
        } catch (\Throwable $th) {
            $this->dispatch('done', error: "Something Went Wrong: " . $th->getMessage());
        }
    }

    function makeOrder()
    {

        try {
            $this->validate();
            $this->order->notes = $this->notes; // Add notes to order
            $this->order->save();
            foreach ($this->productList as $key => $listItem) {
                $this->order->products()->attach($listItem['product_id'], [
                    'quantity' => $listItem['quantity'],
                    'notes' => $listItem['notes'],
                ]);
            }

            return redirect()->route('admin.orders.index');
        } catch (\Throwable $th) {
            $this->dispatch('done', error: "Something Went Wrong: " . $th->getMessage());
        }
    }
    public function render()
    {
        $suppliers = Supplier::where('name', 'like', '%' . $this->supplierSearch . '%')->get();
        $products = Product::with('purchases', 'sales')->where('name', 'like', '%' . $this->productSearch . '%')->get();

        return view('livewire.admin.orders.create', [
            'suppliers' => $suppliers,
            'products' => $products,
        ]);
    }
}
