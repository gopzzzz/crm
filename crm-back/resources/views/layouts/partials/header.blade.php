<aside class="app-sidebar bg-body-secondary shadow" data-bs-theme="dark">
  <!-- Sidebar Brand -->
  <div class="sidebar-brand">
    <a href="#" class="brand-link">
      <span class="brand-text fw-light">SILVER CRM</span>
    </a>
  </div>

  <!-- Sidebar Wrapper -->
  <div class="sidebar-wrapper">
    <nav class="mt-2">
      <ul class="nav sidebar-menu flex-column" data-lte-toggle="treeview" role="menu" data-accordion="false">

        <!-- Dashboard -->
        <li class="nav-item {{ request()->is('home') ? 'menu-open' : '' }}">
          <a href="{{ url('home') }}" class="nav-link {{ request()->is('home') ? 'active' : '' }}">
            <i class="nav-icon bi bi-speedometer"></i>
            <p>Dashboard <i class="nav-arrow bi bi-chevron-right"></i></p>
          </a>
        </li>

        <!-- Leads Menu -->
        <li class="nav-item {{ request()->is('leadslist', 'lead_type', 'roomtype', 'extras', 'assignleads') ? 'active open' : '' }}">
          <a href="#" class="nav-link">
            <i class="nav-icon bi bi-box-seam-fill"></i>
            <p>Leads <i class="nav-arrow bi bi-chevron-right"></i></p>
          </a>
          <ul class="nav nav-treeview">
            <li class="nav-item {{ request()->is('leadslist') ? 'active' : '' }}">
              <a href="{{ url('leadslist') }}" class="nav-link">
                <i class="nav-icon bi bi-circle"></i>
                <p>Lead List</p>
              </a>
            </li>

            @if($role == 1)
              <li class="nav-item {{ request()->is('assignleads') ? 'active' : '' }}">
                <a href="{{ url('assignleads') }}" class="nav-link">
                  <i class="nav-icon bi bi-circle"></i>
                  <p>Assign Leads</p>
                </a>
              </li>
              <li class="nav-item {{ request()->is('lead_type') ? 'active' : '' }}">
                <a href="{{ url('lead_type') }}" class="nav-link">
                  <i class="nav-icon bi bi-circle"></i>
                  <p>Lead Type</p>
                </a>
              </li>
              <li class="nav-item {{ request()->is('roomtype') ? 'active' : '' }}">
                <a href="{{ url('roomtype') }}" class="nav-link">
                  <i class="nav-icon bi bi-circle"></i>
                  <p>Room Type</p>
                </a>
              </li>
              <li class="nav-item {{ request()->is('extras') ? 'active' : '' }}">
                <a href="{{ url('extras') }}" class="nav-link">
                  <i class="nav-icon bi bi-circle"></i>
                  <p>Addons</p>
                </a>
              </li>
            @endif
          </ul>
        </li>

        <!-- Admin-only items -->
        @if($role == 1)
          <li class="nav-item {{ request()->is('bulkupload') ? 'active' : '' }}">
            <a href="{{ url('bulkupload') }}" class="nav-link">
              <i class="nav-icon bi bi-download"></i>
              <p>Bulk Upload</p>
            </a>
          </li>

          <li class="nav-item {{ request()->is('employeelist') ? 'active' : '' }}">
            <a href="{{ url('employeelist') }}" class="nav-link">
              <i class="nav-icon bi bi-grip-horizontal"></i>
              <p>Employees</p>
            </a>
          </li>
        @endif

        <!-- Reminder (Visible to All) -->
        <li class="nav-item {{ request()->is('notification') ? 'active' : '' }}">
          <a href="{{ url('notification') }}" class="nav-link">
            <i class="nav-icon bi bi-star-half"></i>
            <p>Reminder</p>
          </a>
        </li>

      </ul>
    </nav>
  </div>
</aside>
