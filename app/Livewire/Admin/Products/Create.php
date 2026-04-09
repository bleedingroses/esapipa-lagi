<?php

namespace App\Livewire\Admin\Products;

use App\Models\Brand;
use App\Models\Product;
use App\Models\ProductCategory;
use App\Models\Size;
use App\Models\Unit;
use Livewire\Component;

class Create extends Component
{
    public Product $product;
    public $margin = 0;

    function rules()
    {
        return [
            'product.name' => 'required',
            'product.brand_id' => 'required',
            'product.description' => 'nullable',
            'product.unit_id' => 'required',
            'product.size_id' => 'nullable',
            'product.product_category_id' => 'required',
            'product.purchase_price' => 'required',
            'product.sale_price' => 'required',
        ];
    }

    function mount()
    {
        $this->product = new Product();
    }
    function updated()
    {
        $this->validate();
    }

    function save()
    {
        try {
            $this->validate();

            $this->product->save();

            return redirect()->route('admin.products.index');
        } catch (\Throwable $th) {
            $this->dispatch('done', error: "Something Went Wrong: " . $th->getMessage());
        }
    }
    public function render()
    {
        return view('livewire.admin.products.create', [
            'productCategories' => ProductCategory::all(),
            'units' => Unit::all(),
            'brands' => Brand::all(),
            'sizes' => Size::all(),
        ]);
    }

    public function updatedProductPurchasePrice()
    {
        $this->calculateSalePrice();
    }

    public function updatedMargin()
    {
        $this->calculateSalePrice();
    }

    public function calculateSalePrice()
    {
        if ($this->product->purchase_price && $this->margin) {
            $this->product->sale_price =
                $this->product->purchase_price +
                ($this->product->purchase_price * $this->margin / 100);
        }
    }
}
