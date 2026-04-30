

         <aside class="app-sidebar bg-body-secondary shadow" data-bs-theme="dark">
        <!--begin::Sidebar Brand-->
        <div class="sidebar-brand">
          <!--begin::Brand Link-->
          <a href="#" class="brand-link">
            <!--begin::Brand Image-->
         
            <!--end::Brand Image-->
            <!--begin::Brand Text-->
            <span class="brand-text fw-light">GLIMPS CRM</span>
            <!--end::Brand Text-->
          </a>
          <!--end::Brand Link-->
        </div>
        <!--end::Sidebar Brand-->
        <!--begin::Sidebar Wrapper-->
        <div class="sidebar-wrapper">
          <nav class="mt-2">
            <!--begin::Sidebar Menu-->
            <ul
              class="nav sidebar-menu flex-column"
              data-lte-toggle="treeview"
              role="menu"
              data-accordion="false"
            >
              <li class="nav-item menu-open">
                <a href="{{url('home')}}" class="nav-link active">
                  <i class="nav-icon bi bi-speedometer"></i>
                  <p>
                    Dashboard
                    <!-- <i class="nav-arrow bi bi-chevron-right"></i> -->
                  </p>
                </a>
               
              </li>
             
              <li class="nav-item {{ request()->is('leadslist') || request()->is('lead_type') || request()->is('roomtype') || request()->is('extras') ? 'active open' : '' }}"">
                <a href="#" class="nav-link">
                  <i class="nav-icon bi bi-box-seam-fill"></i>
                  <p>
                    Leads
                    <i class="nav-arrow bi bi-chevron-right"></i>
                  </p>
                </a>
                <ul class="nav nav-treeview">
                  <li class="nav-item {{ request()->is('leadslist') ? 'active' : '' }}">
                    <a href="{{ url('leadslist') }}" class="nav-link">
                      <i class="nav-icon bi bi-circle"></i>
                      <p>Lead List</p>
                    </a>
                  </li>
                  @if($role==1)
                  <li class="nav-item {{ request()->is('assignleads') ? 'active' : '' }}">
                    <a href="{{ url('assignleads') }}"" class="nav-link">
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
                      <p>Room Typee</p>
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

               <li class="nav-item {{ request()->is('bulkupload') ? 'active' : '' }}">
                <a href="{{url('bulkupload')}}" class="nav-link">
                  <i class="nav-icon bi bi-download"></i>
                  <p>Bulk Upload</p>
                </a>
              </li>

                 <li class="nav-item {{ request()->is('notification') ? 'active' : '' }}">
                <a href="{{url('notification')}}" class="nav-link">
                  <i class="nav-icon bi bi-star-half"></i>
                  <p>Reminder</p>
                </a>
              </li>
              

              @if($role==1)
           
              <li class="nav-item {{ request()->is('employeelist') ? 'active' : '' }}">
                <a href="{{url('employeelist')}}" class="nav-link">
                  <i class="nav-icon bi bi-grip-horizontal"></i>
                  <p>Employees</p>
                </a>
              </li>

               <li class="nav-item {{ request()->is('customerslist') ? 'active' : '' }}">
                <a href="{{url('customerslist')}}" class="nav-link">
                  <i class="nav-icon bi bi-grip-horizontal"></i>
                  <p>Customers</p>
                </a>
              </li>
           
              
              <!-- <li class="nav-item {{ request()->is('tasklist') ? 'active' : '' }}">
                <a href="{{url('tasklist')}}" class="nav-link">
                  <i class="nav-icon bi bi-star-half"></i>
                  <p>Tasks</p>
                </a>
              </li> -->
              
        
             
                <!-- <li class="nav-item {{ request()->is('createnewtask') ? 'active' : '' }}">
                <a href="{{url('createnewtask')}}" class="nav-link">
                  <i class="nav-icon bi bi-star-half"></i>
                  <p>Task</p>
                </a>
              </li> -->

              
              

              

              @endif

              <li class="nav-item {{ request()->is('menus') ? 'active' : '' }}">
                <a href="{{url('menus')}}" class="nav-link">
                  <i class="nav-icon bi bi-star-half"></i>
                  <p>Task</p>
                </a>
              </li>
              
             

              <li class="nav-item {{ request()->is('meetings') ? 'active' : '' }}">
                <a href="{{url('meetings')}}" class="nav-link">
                  <i class="nav-icon bi bi-star-half"></i>
                  <p>Meeting</p>
                </a>
              </li>

              <li class="nav-item {{ request()->is('customer-support') ? 'active' : '' }}">
    <a href="{{ route('customer_support') }}" class="nav-link">
        <i class="nav-icon bi bi-grip-horizontal"></i>
        <p>Customer Support</p>
    </a>
</li>

<li class="nav-item {{ request()->is('folder') ? 'active' : '' }}">
                <a href="{{url('folder')}}" class="nav-link">
                  <i class="nav-icon bi bi-grip-horizontal"></i>
                  <p>Folder</p>
                </a>
              </li>

              <li class="nav-item {{ request()->is('documents') ? 'active' : '' }}">
                <a href="{{url('documents')}}" class="nav-link">
                  <i class="nav-icon bi bi-grip-horizontal"></i>
                  <p>Documents</p>
                </a>
              </li>

              
              <li class="nav-item {{ request()->is('attendances') ? 'active' : '' }}">
                <a href="{{url('attendances')}}" class="nav-link">
                  <i class="nav-icon bi bi-grip-horizontal"></i>
                  <p>Attendance</p>
                </a>
              </li>
              

              
              
              
            
             
  
            </ul>
            <!--end::Sidebar Menu-->
          </nav>
        </div>
        <!--end::Sidebar Wrapper-->
      </aside>