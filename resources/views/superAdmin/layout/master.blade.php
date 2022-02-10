<!DOCTYPE html>
<html lang="en">

@include('superAdmin.layout.header')

<body data-layout="horizontal" data-topbar="dark">

<!-- Begin page -->
<div id="wrapper">

    <!-- Navigation Bar-->
    <header id="topnav">
        @include('superAdmin.layout.nav_bar')
    </header>
    <!-- End Navigation Bar-->

    <!-- ============================================================== -->
    <!-- Start Page Content here -->
    <!-- ============================================================== -->

    <div class="content-page">
        <div class="content">

            <!-- Start Content-->
            <div class="container-fluid">

                @yield('body')

            </div> <!-- container-fluid -->

        </div> <!-- content -->

        <!-- Footer Start -->
        @include('superAdmin.layout.footer')
        <!-- end Footer -->

    </div>

    <!-- ============================================================== -->
    <!-- End Page content -->
    <!-- ============================================================== -->


</div>
<!-- END wrapper -->

<!-- Right Sidebar -->
{{--@include('superAdmin.layout.right_side_bar')--}}
<!-- /Right-bar -->

@include('superAdmin.layout.scripts')
</body>
</html>
