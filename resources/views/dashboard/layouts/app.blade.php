@include("dashboard.layouts.header")

<body>
  <!-- Layout wrapper -->
  <div class="layout-wrapper layout-content-navbar">
    <div class="layout-container">
      <!-- Menu -->

@include("dashboard.layouts.aside")
      <!-- / Menu -->

      <!-- Layout container -->
      <div class="layout-page">
        <!-- Navbar -->

@include("dashboard.layouts.nav")
@include('sweetalert::alert')

        <!-- / Navbar -->

        <!-- Content wrapper -->
        <div class="content-wrapper">
          <!-- Content -->

          <div class="container-xxl flex-grow-1 container-p-y">
@yield("admin-content")
@yield("customer-service-content")
@yield("sale-officer-content")
@yield("sale-manager-content")
          </div>
          <!-- / Content -->

          <!-- Footer -->
@include("dashboard.layouts.footer")
          <!-- / Footer -->

          <div class="content-backdrop fade"></div>
        </div>
        <!-- Content wrapper -->
      </div>
      <!-- / Layout page -->
    </div>

    <!-- Overlay -->
    <div class="layout-overlay layout-menu-toggle"></div>
  </div>
  <!-- / Layout wrapper -->


  @include("dashboard.layouts.scripts")
</body>
</html>