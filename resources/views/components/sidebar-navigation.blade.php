<div class="sidebar-wrapper">
    <nav class="mt-2"> <!--begin::Sidebar Menu-->
        <ul class="nav sidebar-menu flex-column" data-lte-toggle="treeview" role="menu" data-accordion="false">

            <li class="nav-header">Inisialisasi</li>
            <x-new-nav-link title="Dashboard" bi_icon="bi-speedometer" route="admin.dashboard" />
            {{-- <x-new-nav-link title="Overview" bi_icon="bi-wallet" route="admin.accounts-summary" /> --}}
            @if (auth()->user()->hasPermission('manage roles'))
                <x-new-nav-link-dropdown title="Peran" bi_icon="bi-person-check" route="admin.roles*">
                    <x-new-nav-link title="Daftar Peran" bi_icon="" route="admin.roles.index" />
                    <x-new-nav-link title="Tambah Peran" bi_icon="" route="admin.roles.create" />
                </x-new-nav-link-dropdown>
            @endif
            @if (auth()->user()->hasPermission('manage users'))
                <x-new-nav-link-dropdown title="Akun" bi_icon="bi-people" route="admin.users*">
                    <x-new-nav-link title="Daftar Akun" bi_icon="" route="admin.users.index" />
                    <x-new-nav-link title="Tambah Akun" bi_icon="" route="admin.users.create" />
                </x-new-nav-link-dropdown>
            @endif
            @if (auth()->user()->hasPermission('manage banks'))
                <x-new-nav-link-dropdown title="Bank" bi_icon="bi-bank" route="admin.banks*">
                    <x-new-nav-link title="Daftar Bank" bi_icon="" route="admin.banks.index" />
                    <x-new-nav-link title="Tambah Bank" bi_icon="" route="admin.banks.create" />
                </x-new-nav-link-dropdown>
            @endif
            <li class="nav-header">Kontak</li>
            @if (auth()->user()->hasPermission('manage clients'))
                <x-new-nav-link-dropdown title="Klien" bi_icon="bi-people" route="admin.clients*">
                    <x-new-nav-link title="Daftar Klien" bi_icon="" route="admin.clients.index" />
                    <x-new-nav-link title="Tambah Klien" bi_icon="" route="admin.clients.create" />
                </x-new-nav-link-dropdown>
            @endif
            @if (auth()->user()->hasPermission('manage suppliers'))
                <x-new-nav-link-dropdown title="Supplier" bi_icon="bi-truck-flatbed" route="admin.suppliers*">
                    <x-new-nav-link title="Daftar Supplier" bi_icon="" route="admin.suppliers.index" />
                    <x-new-nav-link title="Tambah Supplier" bi_icon="" route="admin.suppliers.create" />
                </x-new-nav-link-dropdown>

                <li class="nav-header">Manajemen Produk</li>
            @endif
            @if (auth()->user()->hasPermission('manage units'))
                <x-new-nav-link-dropdown title="Satuan" bi_icon="bi-box" route="admin.units*">
                    <x-new-nav-link title="Daftar Satuan" bi_icon="" route="admin.units.index" />
                    <x-new-nav-link title="Tambah Satuan" bi_icon="" route="admin.units.create" />
                </x-new-nav-link-dropdown>
            @endif
            @if (auth()->user()->hasPermission('manage brands'))
                <x-new-nav-link-dropdown title="Merk" bi_icon="bi-tags" route="admin.brands*">
                    <x-new-nav-link title="Daftar Merk" bi_icon="" route="admin.brands.index" />
                    <x-new-nav-link title="Tambah Merk" bi_icon="" route="admin.brands.create" />
                </x-new-nav-link-dropdown>
            @endif
            @if (auth()->user()->hasPermission('manage product categories'))
                <x-new-nav-link-dropdown title="Kategori Produk" bi_icon="bi-boxes"
                    route="admin.product-categories*">
                    <x-new-nav-link title="Daftar Kategori" bi_icon="" route="admin.product-categories.index" />
                    <x-new-nav-link title="Tambah Kategori" bi_icon="" route="admin.product-categories.create" />
                </x-new-nav-link-dropdown>
            @endif
            @if (auth()->user()->hasPermission('manage products'))
                <x-new-nav-link-dropdown title="Produk" bi_icon="bi-box" route="admin.products*">
                    <x-new-nav-link title="Daftar Produk" bi_icon="" route="admin.products.index" />
                    <x-new-nav-link title="Tambah Produk" bi_icon="" route="admin.products.create" />
                </x-new-nav-link-dropdown>
            @endif
            <li class="nav-header">Akun Dan Manajemen</li>


            @if (auth()->user()->hasPermission('manage purchases'))
                <x-new-nav-link-dropdown title="Belanja" bi_icon="bi-cash-stack" route="admin.purchases*">
                    <x-new-nav-link title="Daftar Belanja" bi_icon="" route="admin.purchases.index" />
                    <x-new-nav-link title="Tambah Belanja" bi_icon="" route="admin.purchases.create" />
                </x-new-nav-link-dropdown>
            @endif
            @if (auth()->user()->hasPermission('manage payments'))
                <x-new-nav-link-dropdown title="Pelunasan Belanja" bi_icon="bi-file-text"
                    route="admin.purchase-payments*">
                    <x-new-nav-link title="Daftar Pelunasan" bi_icon=""
                        route="admin.purchase-payments.index" />
                    <x-new-nav-link title="Tambah Pelunasan" bi_icon=""
                        route="admin.purchase-payments.create" />
                </x-new-nav-link-dropdown>
            @endif
            @if (auth()->user()->hasPermission('manage sales'))
                <x-new-nav-link-dropdown title="Penjualan" bi_icon="bi-graph-up" route="admin.sales*">
                    <x-new-nav-link title="Daftar Penjualan" bi_icon="" route="admin.sales.index" />
                    <x-new-nav-link title="Tambah Penjualan" bi_icon="" route="admin.sales.create" />
                </x-new-nav-link-dropdown>
            @endif
            @if (auth()->user()->hasPermission('manage payments'))
                <x-new-nav-link-dropdown title="Pelunasan Jual" bi_icon="bi-file-text" route="admin.sale-payments*">
                    <x-new-nav-link title="Daftar Pelunasan" bi_icon="" route="admin.sale-payments.index" />
                    <x-new-nav-link title="Tambah Pelunasan" bi_icon="" route="admin.sale-payments.create" />
                </x-new-nav-link-dropdown>
            @endif
            @if (auth()->user()->hasPermission('manage orders'))
                <x-new-nav-link-dropdown title="Permintaan Barang" bi_icon="bi-cart" route="admin.orders*">
                    <x-new-nav-link title="Daftar Permintaan" bi_icon="" route="admin.orders.index" />
                    <x-new-nav-link title="Tambah Permintaan" bi_icon="" route="admin.orders.create" />
                </x-new-nav-link-dropdown>
            @endif
            @if (auth()->user()->hasPermission('manage quotations'))
                <x-new-nav-link-dropdown title="Penawaran Barang" bi_icon="bi-quote" route="admin.quotations*">
                    <x-new-nav-link title="Daftar Penawaran" bi_icon="" route="admin.quotations.index" />
                    <x-new-nav-link title="Tambah Penawaran" bi_icon="" route="admin.quotations.create" />
                </x-new-nav-link-dropdown>
            @endif
            @if (auth()->user()->hasPermission('manage invoices'))
                <x-new-nav-link-dropdown title="Invoice" bi_icon="bi-file-text" route="admin.invoices*">
                    <x-new-nav-link title="Daftar Invoice" bi_icon="" route="admin.invoices.index" />
                    <x-new-nav-link title="Tambah Invoice" bi_icon="" route="admin.invoices.create" />
                </x-new-nav-link-dropdown>
            @endif
            {{-- @if (auth()->user()->hasPermission('manage credit notes'))
                <x-new-nav-link-dropdown title="Credit Notes" bi_icon="bi-receipt" route="admin.credit-notes*">
                    <x-new-nav-link title="Credit Notes List" bi_icon="" route="admin.credit-notes.index" />
                    <x-new-nav-link title="Create Credit Note" bi_icon="" route="admin.credit-notes.create" />
                </x-new-nav-link-dropdown>
            @endif
            @if (auth()->user()->hasPermission('manage delivery notes'))
                <x-new-nav-link-dropdown title="Delivery Notes" bi_icon="bi-truck" route="admin.delivery-notes*">
                    <x-new-nav-link title="Delivery Notes List" bi_icon="" route="admin.delivery-notes.index" />
                    <x-new-nav-link title="Create Delivery Note" bi_icon=""
                        route="admin.delivery-notes.create" />
                </x-new-nav-link-dropdown>
            @endif --}}


















        </ul> <!--end::Sidebar Menu-->
    </nav>
</div>
