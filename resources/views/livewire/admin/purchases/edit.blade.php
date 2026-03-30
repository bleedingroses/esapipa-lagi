<div>
    <x-slot:header>Pembelian</x-slot:header>

    <div class="row justify-content-center">
        <div class="col-md-4 col-6 @if (!$productList) w-50 @endif">

            <div class="card">
                <div class="card-header bg-inv-secondary text-inv-primary border-0">
                    <h5>Atur Tanggal dan Supplier</h5>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <label for="" class="form-label">Tanggal Pembelian</label>
                        <input wire:model='purchase.purchase_date' type="date" class="form-control" />
                        @error('purchase.purchase_date')
                            <small id="helpId" class="form-text text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="" class="form-label">Cari Supplier</label>
                        <input type="text" wire:model.live='supplierSearch' class="form-control" />
                        @error('purchase.supplier_id')
                            <small id="helpId" class="form-text text-danger">{{ $message }}</small>
                        @enderror
                        <ul class="list-group mt-2 w-100">
                            @if ($supplierSearch != '')
                                @foreach ($suppliers as $supplier)
                                    <x-supplier-list-item :supplier="$supplier" :purchase="$purchase"/>
                                @endforeach
                            @endif
                        </ul>
                    </div>


                </div>
            </div>
            <div class="card mt-2">
                <div class="card-header bg-inv-secondary text-inv-primary border-0">
                    <h5>Tambahkan Produk</h5>
                </div>
                <div class="card-body">

                    <div class="mb-3">
                        <label for="" class="form-label">Cari Produk</label>
                        <input type="text" wire:model.lazy='productSearch' class="form-control" />
                        <ul class="list-group mt-2 w-100">
                            @if (!empty($productSearch))
                                @foreach ($products as $product)
                                    <x-product-list-group :product="$product" :selectedProductId="$selectedProductId"/>
                                @endforeach
                            @endif
                        </ul>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="" class="form-label">Jumlah</label>
                                <input wire:model='quantity' type="number" min="0" class="form-control" />
                                @error('quantity')
                                    <small id="helpId" class="form-text text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="" class="form-label">Harga Satuan</label>
                                <input wire:model='price' type="number" min="0" class="form-control" />
                                @error('price')
                                    <small id="helpId" class="form-text text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <button
                        onclick="confirm('Are you sure you wish to add this Product to the list')||event.stopImmediatePropagation()"
                        wire:click='addToList' class="btn btn-dark text-inv-primary">Tambahkan</button>
                </div>
            </div>
        </div>
        @if ($productList)
            <div class="col-md-8 col-6">
                <div class="card shadow">
                    <div class="card-header bg-inv-primary text-inv-secondary border-0">
                        <h5 class="text-center text-uppercase">Keranjang</h5>
                    </div>
                    <div class="card-body">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Nama Produk</th>
                                    <th>Jumlah</th>
                                    <th>Harga Satuan</th>
                                    <th>Harga Total</th>
                                    <th class="text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if ($productList)
                                    @php
                                        $total = 0;
                                    @endphp
                                    @foreach ($productList as $key => $listItem)
                                        @php
                                            $product = $productsCache[$listItem['product_id']] ?? null;
                                        @endphp
                                        <tr>
                                            
                                            <td scope="row">{{ $product->id }}</td>
                                            <td> {{ $product->name }} <br>
                                                <small class="text-muted">
                                                    {{ ($product->quantity ?? '-') . ($product->unit->name ?? '') }}
                                                </small>
                                            </td>
                                            <td>{{ $listItem['quantity'] }}</td>
                                            <td>Rp {{ number_format($listItem['price'], 2) }}</td>
                                            <td>Rp {{ number_format($listItem['quantity'] * $listItem['price'], 2) }}</td>
                                            <td class="text-center">
                                                @if ($listItem['quantity'] > 1)
                                                    <button wire:click='subtractQuantity({{ $key }})'
                                                        class="btn btn-warning">
                                                        <i class="bi bi-dash"></i>
                                                    </button>
                                                @endif
                                                <button wire:click='addQuantity({{ $key }})'
                                                    class="btn btn-success">
                                                    <i class="bi bi-plus"></i>
                                                </button>
                                                <button
                                                    onclick="if(!confirm('Are you sure?')) return false"
                                                    wire:click='deleteCartItem({{ $key }})'
                                                    class="btn btn-danger">
                                                    <i class="bi bi-trash-fill"></i>
                                                </button>
                                            </td>
                                        </tr>

                                        @php
                                            $total += $listItem['quantity'] * $listItem['price'];
                                        @endphp
                                    @endforeach
                                    <tr>
                                        <td colspan="2" style="font-size: 18px">
                                            <strong>TOTAL</strong>
                                        </td>
                                        <td></td>
                                        <td></td>
                                        <td style="font-size: 18px">
                                            <strong>Rp {{ number_format($total, 2) }}</strong>
                                        </td>
                                        <td></td>
                                    </tr>
                                @endif
                            </tbody>
                        </table>
                            <button
                                wire:click='makePurchase'
                                wire:loading.attr="disabled"
                                class="btn btn-dark w-100">
                                <span wire:loading.remove>Update</span>
                                <span wire:loading>Loading...</span>
                            </button>

                    </div>
                </div>
            </div>
        @endif
    </div>
</div>
