        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous">
        </script>
        <script src="{{ asset('admin/dist/js/scripts.js') }}"></script>

        <script>
            

            //$( window ).resize(function() {
                if ($(window).width() < 700) {
                    $("#layoutSidenav").hide();
                    $("#alertPageMinimum").show();
                } else {
                    $("#layoutSidenav").show();
                    $("#alertPageMinimum").hide();
                }
            //});
        </script>

        {{--  <script src="{{ asset('admin/dist/js/datatables/datatables-simple-demo.js') }}"></script>  --}}
        {{--  <script src="{{ asset('js/app.js') }}" type="text/javascript"></script>  --}}

        @yield('script')

        </body>


        </html>
