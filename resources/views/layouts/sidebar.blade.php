 <!-- ======= Sidebar ======= -->
 <aside id="sidebar" class="sidebar">

<ul class="sidebar-nav" id="sidebar-nav">

  <li class="nav-heading">Dashboard</li>
  <li class="nav-item">
    <a class="nav-link " href="/dashboard">
      <i class="bi bi-grid"></i>
      <span>Dashboard</span>
    </a>
  </li>
  <!-- End Dashboard Nav -->

  @if(auth()->user()->role_id == 1 )
  <li class="nav-heading">Management Inventory</li>
  <li class="nav-item">
    <a class="nav-link collapsed" data-bs-target="#components-nav" data-bs-toggle="collapse" href="#">
      <i class="bi bi-journal-album"></i><span>Inventory</span><i class="bi bi-chevron-down ms-auto"></i>
    </a>
    <ul id="components-nav" class="nav-content collapse " data-bs-parent="#sidebar-nav">
      <li>
        <a href="/category">
          <i class="bi bi-circle"></i><span>Kategori</span>
        </a>
      </li>
      <li>
        <a href="/product">
          <i class="bi bi-circle"></i><span>Produk</span>
        </a>
      </li>
      <li>
        <a href="/principal/stock">
          <i class="bi bi-circle"></i><span>Stock</span>
        </a>
      </li>
    </ul>
  </li>

  <li class="nav-heading">Management Distributor</li>
  <li class="nav-item">
    <a class="nav-link collapsed" data-bs-target="#icons-nav" data-bs-toggle="collapse" href="/list-distributor">
      <i class="bi bi-building"></i><span>Distributor</span><i class="bi bi-chevron-down ms-auto"></i>
    </a>
    <ul id="icons-nav" class="nav-content collapse " data-bs-parent="#sidebar-nav">
      <li>
        <a href="/list-distributor">
          <i class="bi bi-circle"></i><span>List Distributor</span>
        </a>
      </li>
    </ul>
  </li>
  @endif

  @if(auth()->user()->role_id == 2)
  <li class="nav-heading">Management Inventory</li>
  <li class="nav-item">
    <a class="nav-link collapsed" data-bs-target="#components-nav" data-bs-toggle="collapse" href="#">
      <i class="bi bi-journal-album"></i><span>Inventory</span><i class="bi bi-chevron-down ms-auto"></i>
    </a>
    <ul id="components-nav" class="nav-content collapse " data-bs-parent="#sidebar-nav">
      <li>
        <a href="/distributor/product">
          <i class="bi bi-circle"></i><span>Product</span>
        </a>
      </li>
      <li>
        <a href="/distributor/stock">
          <i class="bi bi-circle"></i><span>Stock</span>
        </a>
      </li>
    </ul>
  </li>
  <li class="nav-heading">Management PO</li>
  <li class="nav-item">
    <a class="nav-link collapsed" data-bs-target="#purchase-nav" data-bs-toggle="collapse" href="#">
      <i class="bi bi-journal-album"></i><span>Purchase Order</span><i class="bi bi-chevron-down ms-auto"></i>
    </a>
    <ul id="purchase-nav" class="nav-content collapse " data-bs-parent="#sidebar-nav">
      <li>
        <a href="/distributor/purchase-order">
          <i class="bi bi-circle"></i><span>Purchase Order</span>
        </a>
      </li>
    </ul>
  </li>
  @endif
  <li class="nav-heading">Management Pengguna</li>
  <!-- Start User Nav -->
  <li class="nav-item">
    <a class="nav-link collapsed" data-bs-target="#user-nav" data-bs-toggle="collapse" href="#">
      <i class="bi bi-people-fill"></i><span>Pengguna</span><i class="bi bi-chevron-down ms-auto"></i>
    </a>
    <ul id="user-nav" class="nav-content collapse " data-bs-parent="#sidebar-nav">
      <li>
        <a href="#">
          <i class="bi bi-circle"></i><span>Pengaturan</span>
        </a>
      </li>
    </ul>
  </li>
  <!-- End User Nav -->


  
</ul>

</aside><!-- End Sidebar-->