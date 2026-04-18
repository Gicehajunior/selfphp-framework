        <!-- Footer -->
        <!-- FSection --> 
        {{ @extends("__app.crm.fsection__") }}
        <!-- /FSection -->

        <!-- include jquery -->
        <script type="text/javascript" src="{{ asset_path('assets/jquery/js/jquery.min.js') }}"></script>

        <!-- include popper -->
        <script type="text/javascript" src="{{ asset_path('assets/popper/js/popper.js') }}"></script>

        <!-- include bootstrap js -->
        <script type="text/javascript" src="{{ asset_path('bootstrap/<?= bootstrap() ?>/js/bootstrap.min.js') }}"></script>

        <!-- select 2 js library -->
        <script type="text/javascript" src="{{ asset_path('bootstrap/<?= bootstrap() ?>/js/select2.js') }}"></script>

        <!-- bootstrap datepicker js library -->
        <script type="text/javascript" src="{{ asset_path('bootstrap/<?= bootstrap() ?>/js/bootstrap-datepicker.js') }}"></script>

        <!-- toastr js library -->
        <script type="text/javascript" src="{{ asset_path('assets/toastr/js/toastr.min.js') }}"></script>

        <!-- DataTables -->
        <!-- <script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script> -->
        <script type="text/javascript" src="{{ asset_path('assets/jquery/js/jquery.dataTables.js') }}"></script>

        <!-- printing library -->
        <script src="https://printjs-4de6.kxcdn.com/print.min.js"></script>
        <!-- <script type="text/javascript" src="{{ asset_path('assets/printjs/js/print.js') }}"></script> -->

        <!-- Page JS -->
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <!-- <script type="text/javascript" src="{{ asset_path('assets/sweetalert/js/sweetalert2.js') }}"></script> -->

        <!-- local js script -->
        <script src="{{ asset_path('js/utility/functions.js') }}"></script>
        <script src="{{ asset_path('js/utility/global.js') }}"></script>
        <script src="{{ asset_path('js/utility/auth.js') }}"></script>
        <script src="{{ asset_path('js/utility/app.js') }}"></script>
        <script src="{{ asset_path('js/maps/settings.js') }}"></script>
        <script src="{{ asset_path('js/lang/en.js') }}"></script>

        <!-- Master Class Initializations -->
        <script src="{{ asset_path('js/global/master.js')}}"></script>

        <!-- Add AOS (Animate On Scroll) for better effects -->
        <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
        <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
        <script>
            AOS.init({
                duration: 1000,
                once: true
            });
        </script>