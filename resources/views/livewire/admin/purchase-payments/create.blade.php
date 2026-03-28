<div>
    <x-slot:header>Pelunasan Pembelian</x-slot:header>

    <div class="row justify-content-center">
        <div class="col-md-6 col-4">
            <div class="card">
                <div class="card-header bg-inv-secondary text-inv-primary border-0">
                    <h5>Atur Tanggal Dan Supplier</h5>
                </div>
                <div class="card-body">
                    <div class="row">

                        <div class="mb-3">
                            <label for="" class="form-label">Tanggal Pembelian</label>
                            <input wire:model='purchase_payment.payment_time' type="datetime-local"
                                class="form-control" />
                            @error('purchase_payment.payment_time')
                                <small id="helpId" class="form-text text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="ref" class="form-label">Referensi</label>
                            <input
                            wire:model='purchase_payment.transaction_reference'
                                type="text"
                                class="form-control"
                                name="ref"
                                id="ref"
                                aria-describedby="ref"
                                placeholder="Enter your transaction reference"
                            />

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
                                        <x-supplier-payment-list-item :supplier="$supplier" :purchase_payment="$purchase_payment" />
                                    @endforeach
                                @endif
                            </ul>
                        </div>

                        <div class="mb-3">
                            <label for="" class="form-label">Total Pembelian</label>
                            <div class="input-group">
                                <input wire:model='purchase_payment.amount' type="number" class="form-control" />
                                <button wire:click='takeFullBalance' class="btn btn-outline-secondary">
                                    <i class="bi bi-wallet"></i>
                                </button>
                            </div>
                            @error('purchase_payment.amount')
                                <small id="helpId" class="form-text text-danger">{{ $message }}</small>
                            @enderror
                        </div>


                        <hr>

                        <div class="col-md-6 col-12">
                            <div class="mb-3">
                                <label for="" class="form-label">Beli</label>
                                <select wire:model='selectedPurchaseId' class="form-select" name=""
                                    id="">
                                    @if ($purchase_payment->supplier)
                                        <option value=""></option>
                                        @foreach ($purchase_payment->supplier->purchases as $purchase)
                                            <option value="{{ $purchase->id }}">Purchase #{{ $purchase->id }} <br>
                                                Balance:
                                                Rp {{ number_format($purchase->total_balance) }}</option>
                                        @endforeach
                                    @endif
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6 col-12">
                            <label for="" class="form-label">Masukkan Jumlah</label>
                            <div class="input-group mb-3">
                                <input wire:model='amount' type="number" class="form-control" />
                                <button wire:click='takeBalance' class="btn btn-outline-secondary">
                                    <i class="bi bi-wallet"></i>
                                </button>
                            </div>
                            @error('amount')
                                <small id="helpId" class="form-text text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>
                    <button
                        onclick="confirm('Are you sure you wish to add this Purchase to the list')||event.stopImmediatePropagation()"
                        wire:click='addToList' class="btn btn-dark text-inv-primary">Tambahkan</button>
                </div>
            </div>
        </div>
        <div class="col-md-6 col-8">
            <div class="card shadow">
                <div class="card-header bg-inv-primary text-inv-secondary border-0">
                    <h5 class="text-center text-uppercase">Keranjang</h5>
                </div>
                <div class="card-body">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Supplier</th>
                                <th>Tanggal Pembelian</th>
                                <th>Jumlah Total</th>
                                <th>Jumlah Dialokasikan</th>
                                <th class="text-center">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if ($purchaseList)
                                @php
                                    $total = 0;
                                @endphp
                                @foreach ($purchaseList as $key => $listItem)
                                    <tr>
                                        <td scope="row">
                                            {{ App\Models\Purchase::find($listItem['purchase_id'])->id }}
                                        </td>
                                        <td scope="row">
                                            {{ App\Models\Purchase::find($listItem['purchase_id'])->name }}
                                        </td>
                                        <td>
                                            {{ Carbon\Carbon::parse(App\Models\Purchase::find($listItem['purchase_id'])->purchase_date)->format('jS F,Y') }}
                                            <br>

                                        </td>
                                        <td>
                                            {{ number_format(App\Models\Purchase::find($listItem['purchase_id'])->total_amount, 2) }}
                                            <br>

                                        </td>
                                        <td>
                                            {{ number_format($listItem['amount'], 2) }}
                                        </td>

                                        <td class="text-center">

                                            <button
                                                onclick="confirm('Are you sure you wish to remove this item from the list')||event.stopImmediatePropagation()"
                                                wire:click='deleteListItem({{ $key }})'
                                                class="btn btn-danger">
                                                <i class="bi bi-trash-fill"></i>
                                            </button>
                                        </td>
                                    </tr>

                                    @php
                                        $total += $listItem['amount'];
                                    @endphp
                                @endforeach
                                <tr>
                                    <td colspan="2" style="font-size: 18px">
                                        <strong>TOTAL</strong>
                                    </td>
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
                        onclick="confirm('Are you sure you wish to make the payment')||event.stopImmediatePropagation()"
                        wire:click='savePayment' class="btn btn-dark text-inv-primary w-100">Simpan Pembayaran</button>

                </div>
            </div>
        </div>
    </div>
</div>
