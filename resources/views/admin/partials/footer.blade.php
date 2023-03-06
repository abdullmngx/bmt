        </div>
    </div>
</div>


<!-- Javascript -->
<script src="{{ asset('assets1/bundles/libscripts.bundle.js') }}"></script>    
<script src="{{ asset('assets1/bundles/vendorscripts.bundle.js') }}"></script>

<!-- page vendor js file -->
<script src="{{ asset('assets1/vendor/toastr/toastr.js') }}"></script>
<script src="{{ asset('assets1/bundles/c3.bundle.js') }}"></script>

@yield('datatablejs')
@yield('chartjsjs')

<script src="{{ asset('assets1/vendor/sweetalert/sweetalert.min.js') }}"></script> <!-- SweetAlert Plugin Js --> 

<!-- page js file -->
<script src="{{ asset('assets1/bundles/mainscripts.bundle.js') }}"></script>
<script src="{{ asset('index.js') }}"></script>
<script>
    setTimeout(() => {
        $('body').addClass('layout-fullwidth')
        $('body').addClass('sidebar_toggle')
        $('body').addClass('right_icon_toggle')
    }, 1000);
    $('input').attr('autocomplete', 'off')
</script>
@yield('scripts')
</body>
</html>