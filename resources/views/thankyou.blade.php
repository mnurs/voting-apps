@include('include/header')

<body>
    <div id="app">

        @include('include/navbar')

        <div id="plktm">
            <div class="container">
                <h3 class="text-center mt-10 mb-4">
                    Terima kasih telah berpartisipasi pada Pemilihan Ketua Umum Ikastara 2023/2026
                </h3>

                <p class="text-center">Bukti pilihan Anda telah terkirim melalui email yang didaftarkan</p>

                <div class="text-center">
                    <a href="{{ route('home') }}" class="link-black">Kembali ke Home</a>
                </div>
            </div>
        </div>
    </div>

    {{-- script prevent back button after redirect to this success page --}}
    <script>
        window.onload = function() {
            history.pushState(null, null, location.href);
            window.onpopstate = function() {
                history.go(1);
            };
        };
    </script>


    @include('include/footer')
</body>

</html>