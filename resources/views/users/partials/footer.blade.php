<!-- footer-->
<div class="footer">
    <div class="row no-gutters justify-content-center">
        <div class="col-auto">
            <a href="/users/dashboard" class="{{ request()->routeIs('user.dashboard') ? 'active' : '' }}">
                <i class="material-icons">home</i>
                <p>Dashboard</p>
            </a>
        </div>
        <div class="col-auto">
            <a href="/users/referrals" class="{{ request()->routeIs('user.referrals') ? 'active' : '' }}">
                <i class="material-icons">share</i>
                <p>Referrals</p>
            </a>
        </div>
        <div class="col-auto">
            <a href="/users/earnings" class="{{ request()->routeIs('user.earnings') ? 'active' : '' }}">
                <i class="material-icons">account_balance_wallet</i>
                <p>Earnings</p>
            </a>
        </div>
        <div class="col-auto">
            <a href="/users/withdrawals" class="{{ request()->routeIs('user.withdrawals') ? 'active' : '' }}">
                <i class="material-icons">credit_card</i>
                <p>Withdrawals</p>
            </a>
        </div>
        <div class="col-auto">
            <a href="/users/profile" class="{{ request()->routeIs('user.profile') ? 'active' : '' }}">
                <i class="material-icons">account_circle</i>
                <p>Profile</p>
            </a>
        </div>
    </div>
</div>


<!-- color settings style switcher -->
<div class="color-picker">
    <div class="row">
        <div class="col text-left">
            <div class="selectoption">
                <input type="checkbox" id="darklayout" name="darkmode">
                <label for="darklayout">Dark</label>
            </div>
        </div>
        <div class="col-auto">
            <button class="btn btn-link text-secondary btn-round colorsettings2"><span class="material-icons">close</span></button>
        </div>
    </div>
</div>

<!-- Required jquery and libraries -->
<script src="/js/jquery-3.3.1.min.js"></script>
<script src="/js/popper.min.js"></script>
<script src="/vendor/bootstrap/js/bootstrap.min.js"></script>

<!-- cookie js -->
<script src="/js/jquery.cookie.js"></script>

<!-- Swiper slider  js-->
<script src="/vendor/swiper/js/swiper.min.js"></script>

<!-- Customized jquery file  -->
<script src="/js/main.js"></script>
<script src="/js/color-scheme-demo.js"></script>

<!-- PWA app service registration and works -->
<script src="/js/pwa-services.js"></script>
<script src="//code.tidio.co/9va2kp1seullfuypavbpmftb2rpxp3ms.js" async></script>

<!-- page level custom script -->
<script src="/js/app.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js" integrity="sha512-VEd+nq25CkR676O+pLBnDW09R7VQX9Mdiij052gVCp5yVH3jGtH70Ho/UUv4mJDsEdTvqRCFZg0NKGiojGnUCw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script>
        document.querySelector(".copy").onclick = function () {
            document.querySelector("#wallet").select();
            if (document.execCommand("copy"))
            {
                toastr.success('Link copied')
            }
        };
</script>
@yield('scripts')
</body>

</html>