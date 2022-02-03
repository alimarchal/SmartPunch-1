<!DOCTYPE html>
<html lang="en">

@include('ibr.layout.header')

<body data-layout="horizontal" data-topbar="dark">

<!-- Begin page -->
<div id="wrapper">

    <!-- Navigation Bar-->
    <header id="topnav">
        @include('ibr.layout.nav_bar')
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
        @include('ibr.layout.footer')
        <!-- end Footer -->

    </div>

    <!-- ============================================================== -->
    <!-- End Page content -->
    <!-- ============================================================== -->


</div>
<!-- END wrapper -->

<!-- Right Sidebar -->
{{--@include('theme.right_side_bar')--}}
<!-- /Right-bar -->

@include('ibr.layout.scripts')

</body>
</html>
