<div class="sidebar-wrapper">
    <nav class="mt-2"> <!--begin::Sidebar Menu-->
        <ul class="nav sidebar-menu flex-column" data-lte-toggle="treeview" role="menu" data-accordion="false">

            <li class="nav-header">Inisialisasi</li>
            <x-new-nav-link title="Dashboard" bi_icon="bi-speedometer" route="admin.dashboard" />
            {{-- <x-new-nav-link title="Overview" bi_icon="bi-wallet" route="admin.accounts-summary" /> --}}
            @if (auth()->user()->hasPermission('manage roles'))
                <x-new-nav-link title="Peran" bi_icon="bi-person-check" route="admin.roles.index" />
            @endif
            @if (auth()->user()->hasPermission('manage users'))
                <x-new-nav-link title="Akun" bi_icon="bi-people" route="admin.users.index" />
            @endif
            @if (auth()->user()->hasPermission('manage banks'))
                <x-new-nav-link title="Bank" bi_icon="bi-bank" route="admin.banks.index" />
            @endif
            <li class="nav-header">Kontak</li>
            @if (auth()->user()->hasPermission('manage clients'))
                <x-new-nav-link title="Klien" bi_icon="bi-people" route="admin.clients.index" />
            @endif
            @if (auth()->user()->hasPermission('manage suppliers'))
                <x-new-nav-link title="Supplier" bi_icon="bi-truck-flatbed" route="admin.suppliers.index" />

                <li class="nav-header">Manajemen Produk</li>
            @endif
            @if (auth()->user()->hasPermission('manage units'))
                <x-new-nav-link title="Satuan" bi_icon="bi-box" route="admin.units.index" />
            @endif
            @if (auth()->user()->hasPermission('manage sizes'))
                <x-new-nav-link title="Ukuran" bi_icon="bi-box2" route="admin.sizes.index" />
            @endif
            @if (auth()->user()->hasPermission('manage brands'))
                <x-new-nav-link title="Merk" bi_icon="bi-tags" route="admin.brands.index" />
            @endif
            @if (auth()->user()->hasPermission('manage product categories'))
                <x-new-nav-link title="Kategori Produk" bi_icon="bi-boxes" route="admin.product-categories.index" />
            @endif
            @if (auth()->user()->hasPermission('manage products'))
                <x-new-nav-link title="Produk" bi_icon="bi-box" route="admin.products.index" />
            @endif
            <li class="nav-header">Akun Dan Manajemen</li>
            @if (auth()->user()->hasPermission('manage cash accounts'))
                <x-new-nav-link title="Kas" bi_icon="bi-wallet2" route="admin.cash-accounts.index" />
            @endif
            @if (auth()->user()->hasPermission('manage purchases'))
                <x-new-nav-link title="Belanja Produk" bi_icon="bi-cash-stack" route="admin.purchases.index" />
                <x-new-nav-link title="Belanja Operasional" bi_icon="bi-tools" route="admin.operational-expenses.index" />
            @endif
            @if (auth()->user()->hasPermission('manage sales'))
                <x-new-nav-link title="Penjualan" bi_icon="bi-graph-up" route="admin.sales.index" />
            @endif
            @if (auth()->user()->hasPermission('manage orders'))
                <x-new-nav-link title="Permintaan Barang" bi_icon="bi-cart" route="admin.orders.index" />
            @endif
            @if (auth()->user()->hasPermission('manage quotations'))
                <x-new-nav-link title="Penawaran Barang" bi_icon="bi-quote" route="admin.quotations.index" />
            @endif
            @if (auth()->user()->hasPermission('manage invoices'))
                <x-new-nav-link title="Invoice" bi_icon="bi-file-text" route="admin.invoices.index" />
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
