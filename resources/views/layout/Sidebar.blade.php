
<nav class="sidebar sidebar-offcanvas" id="sidebar">
<ul class="nav">
@guest
  <li class="nav-item nav-profile">
      <a href="#" class="nav-link">
          <div class="nav-profile-image">
              <img src="{{ asset('assets/images/faces/face1.jpg') }}" />
          </div>
          <div class="nav-profile-text d-flex flex-column">
              <span class="font-weight-bold mb-2">Guest</span>
              <span class="text-secondary text-small">Customer</span>
          </div>
      </a>
  </li>

  <li class="nav-item">
      <a class="nav-link" href="/order">
          <span class="menu-title">Pesan Makanan</span>
          <i class="fa fa-cutlery menu-icon"></i>
      </a>
  </li>
@endguest

@if(Auth::check())
  <li class="nav-item nav-profile">
      <a href="#" class="nav-link">
          <div class="nav-profile-image">
              <img src="{{ asset('assets/images/faces/face1.jpg') }}" />
          </div>
          <div class="nav-profile-text d-flex flex-column">
              <span class="font-weight-bold mb-2">{{ Auth::user()->name }}</span>

              @if(session('vendor_id'))
                  <span class="text-secondary text-small">Vendor</span>
              @else
                  <span class="text-secondary text-small">Project Manager</span>
              @endif

          </div>
        <i class="mdi mdi-bookmark-check text-success nav-profile-badge"></i>
      </a>
  </li>
@endif

@if(session('vendor_id'))

  <li class="nav-item">
      <a class="nav-link" href="/vendor/dashboard">
          <span class="menu-title">Dashboard Vendor</span>
          <i class="mdi mdi-home menu-icon"></i>
      </a>
  </li>

  <li class="nav-item">
      <a class="nav-link" href="/vendor/menu">
          <span class="menu-title">Kelola Menu</span>
          <i class="fa fa-cutlery menu-icon"></i>
      </a>
  </li>

  <li class="nav-item">
      <a class="nav-link" href="/vendor/pesanan">
          <span class="menu-title">Pesanan Lunas</span>
          <i class="fa fa-shopping-cart menu-icon"></i>
      </a>
  </li>

@endif


@if(Auth::check() && !session('vendor_id'))

  <li class="nav-item">
      <a class="nav-link" href="{{ route('dashboard') }}">
          <span class="menu-title">Dashboard</span>
          <i class="mdi mdi-home menu-icon"></i>
      </a>
  </li>

  <li class="nav-item">
      <a class="nav-link" href="{{ route('kategori.index') }}">
          <span class="menu-title">Kategori</span>
          <i class="mdi mdi-format-list-bulleted menu-icon"></i>
      </a>
  </li>

  <li class="nav-item">
      <a class="nav-link" href="{{ route('buku.index') }}">
          <span class="menu-title">Buku</span>
          <i class="fa fa-book menu-icon"></i>
      </a>
  </li>

  <li class="nav-item">
      <a class="nav-link" href="{{ route('barang.index') }}">
          <span class="menu-title">Barang</span>
          <i class="fa fa-inbox menu-icon"></i>
      </a>
  </li>

  <li class="nav-item">
    <a class="nav-link" data-bs-toggle="collapse" href="#menu-tabel" aria-expanded="false">
      <span class="menu-title">Tabel</span>
      <i class="menu-arrow"></i>
      <i class="fa fa-table menu-icon"></i>
    </a>
    <div class="collapse" id="menu-tabel" data-bs-parent="#sidebar">
      <ul class="nav flex-column sub-menu">
        <li class="nav-item">
          <a class="nav-link" href="{{ route('Table') }}">Tabel Barang</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="{{ route('Datatables') }}">Datatables Barang</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="{{ route('kota') }}">Kota</a>
        </li>
      </ul>
    </div>
  </li>

  <li class="nav-item">
    <a class="nav-link" data-bs-toggle="collapse" href="#menu-pdf" aria-expanded="false" aria-controls="menu-pdf">
      <span class="menu-title">Download PDF</span>
      <i class="menu-arrow"></i>
      <i class="fa fa-download menu-icon"></i>
    </a>
    <div class="collapse" id="menu-pdf">
      <ul class="nav flex-column sub-menu">
        <li class="nav-item">
          <a class="nav-link" href="{{ route('pdf.sertifikat') }}">Sertifikat</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="{{ route('pdf.undangan') }}">Undangan</a>
        </li>
      </ul>
    </div>
  </li>

  <li class="nav-item">
    <a class="nav-link" data-bs-toggle="collapse" href="#wilayah" aria-expanded="false" aria-controls="wilayah">
      <span class="menu-title">Wilayah</span>
      <i class="menu-arrow"></i>
      <i class="fa fa-location-arrow menu-icon"></i>
    </a>
    <div class="collapse" id="wilayah">
      <ul class="nav flex-column sub-menu">
        <li class="nav-item">
          <a class="nav-link" href="{{ route('wilayah.index') }}">Wilayah</a>
        </li>
      </ul>
    </div>
  </li>

  <li class="nav-item">
    <a class="nav-link" data-bs-toggle="collapse" href="#pos" aria-expanded="false" aria-controls="pos">
      <span class="menu-title">POS</span>
      <i class="menu-arrow"></i>
      <i class="fa fa-money menu-icon"></i>
    </a>
    <div class="collapse" id="pos">
      <ul class="nav flex-column sub-menu">
        <li class="nav-item">
          <a class="nav-link" href="{{ route('pos.index1') }}">JQuery</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="{{ route('pos.index2') }}">Axios</a>
        </li>
      </ul>
    </div>
  </li>
@endif

</ul>
</nav>
          