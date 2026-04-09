<div>
    <x-slot:header>Produk</x-slot:header>

    <div class="mb-3">
        <a href="{{ route('admin.products.create') }}" class="btn btn-dark text-inv-primary">
            <i class="bi bi-plus-circle"></i> Tambah Produk
        </a>
    </div>

    <div class="card">
        <div class="card-header bg-inv-secondary text-inv-primary border-0">
            <h5>Daftar Produk</h5>
        </div>
        <div class="card-body table-responsive">
            <table class="table table-hover  ">
                <thead class="thead-inverse">
                    <tr>
                        <th>No</th>
                        <th>Detail Produk</th>
                        <th>Kategori</th>
                        <th>Satuan</th>
                        <th>Ukuran</th>
                        <th>Total Stok</th>
                        <th class="text-center">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($products as $product)
                        <tr>
                            <td scope="row">{{ $loop->iteration }}</td>
                            <td>
                                <h6>{{ $product->name }}</h6>
                                <small>{{ $product->description ?? 'N/A' }}</small>
                            </td>
                            <td>{{ $product->category->name }}</td>
                            <td>
                                {{ $product->unit->name }}
                            </td>
                            <td>
                                {{ $product->size->name ?? 'N/A' }}
                            </td>
                            <td>
                                {{ $product->inventory_balance }}
                            </td>
                            <td class="text-center">
                                <a wire:navigate href="{{ route('admin.products.edit', $product->id) }}"
                                    class="btn btn-secondary">
                                    <i class="bi bi-pencil-square"></i>
                                </a>
                                <button onclick="confirm('Are you sure you wish to DELETE this product?')||event.stopImmediatePropagation()" class="btn btn-danger" wire:click='delete({{ $product->id }})'>
                                    <i class="bi bi-trash-fill"></i>
                                </button>

                            </td>
                        </tr>
                    @endforeach
                </tbody>
                <tfoot>
                    <tr>{{ $products->links() }}</tr>
                </tfoot>
            </table>
            {{ $products->links() }}
        </div>
    </div>
</div>
