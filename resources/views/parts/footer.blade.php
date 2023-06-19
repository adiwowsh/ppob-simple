
<!-- Footer Menu -->
<div class="footer">
    <a href="{{ url('/') }}" class="icon {{ Request::is('/') ? 'active' : '' }}"><i class="fa fa-home"></i></a>
    <a href="{{ url('topup') }}" class="icon {{ Request::is('topup') ? 'active' : '' }}"><i class="fa fa-money"></i></a>
    <a href="{{ "https://wa.me/" . env('CS_WA') }}" class="icon {{ Request::is('/wa-me') ? 'active' : '' }}"><i class="fa fa-whatsapp"></i></a>
    <a href="{{ url('account') }}" class="icon {{ Request::is('account') ? 'active' : '' }}"><i class="fa fa-user"></i></a>
</div>

<!-- Cart Modal -->
<div id="cartModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="cartModalLabel"
     aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="cartModalLabel">Daftar belanja</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                @if(Auth::check())
                    <p>Your cart is currently empty.</p>
                    <p>
                        Silahkan TOPUP saldo dengan cara menghubungi nomor server kami disini
                    </p>

                    <a href="{{ url('topup') }}" class="btn btn-primary">
                        <i class="fa fa-money"></i> Topup
                    </a>
                @else
                    Harap login untuk mulai belanja
                    <a href="{{ url('login') }}" class="btn btn-primary">Login</a>
                @endif
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>


<!-- Buy Modal -->
<div class="modal fade" id="buyModal" tabindex="-1" role="dialog" aria-labelledby="buyModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="buyModalLabel">Purchase Confirmation</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                @if(Auth::check())
                    <p>
                        Mohon maaf, saldo anda <b>Rp0</b>
                    </p>
                    <p>
                        Silahkan TOPUP saldo dengan cara menghubungi nomor server kami disini
                    </p>

                    <a href="{{ 'https://wa.me/' . env('CS_WA_BOT') . '?text=' . urlencode('TOPUP#300000') }}" class="btn btn-primary">
                        <i class="fa fa-whatsapp"></i> Chat Server {{ env('CS_WA_BOT') }}
                    </a>
                @else
                    <p>
                        Silahkan login atau daftar terlebih dahulu
                    </p>
                    <a href="{{ url('login') }}" class="btn btn-primary">Login</a>
                @endif
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<script>
    $(document).ready(function() {
        var slideMenu = $(".slide-menu");

        // Toggle slide menu
        $(".menu-btn").click(function(e) {
            e.stopPropagation(); // Prevent the click event from bubbling up

            if (slideMenu.hasClass("open")) {
                slideMenu.removeClass("open");
            } else {
                slideMenu.addClass("open");
            }
        });

        // Close slide menu when clicking outside or on the close button
        $(document).on("click", function(event) {
            if (
                !$(event.target).closest(slideMenu).length &&
                !$(event.target).closest(".menu-btn").length &&
                !$(event.target).hasClass("close-btn")
            ) {
                slideMenu.removeClass("open");
            }
        });

        // Close slide menu when clicking on the close button
        $(".slide-menu .close-btn").click(function() {
            slideMenu.removeClass("open");
        });

        // Open cart modal
        $(".cart-btn").click(function() {
            $("#cartModal").modal("show");
        });
    });
</script>

@yield('js','')
</body>

</html>
