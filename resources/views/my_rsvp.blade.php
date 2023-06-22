@include('include/header')

<body>
    <div id="app">
        @include('include/navbar')

        <div id="plktm">
            <div class="container">
                <!-- START CENTERED WHITE CONTAINER -->
                <table role="presentation" class="main">

                    <!-- START MAIN CONTENT AREA -->
                    <tr>
                        <td class="wrapper">
                            <table role="presentation" border="0" cellpadding="0" cellspacing="0" align="center">
                                <tr>
                                    <td>
                                        <p style="font-size: 18px; font-weight: 600;">Terima Kasih Telah Melakukan RSVP Pada Musyawarah Nasional X Ikatan
                                            Alumni SMA
                                            Taruna Nusantara</p>
                                        <p
                                            style="font-size: 18px; margin-bottom: 10px; text-indent: -30px; padding-left: 30px; line-height: 1;">
                                            <img src="{{ asset('images/icons/ic-clock.png') }}" alt=""
                                                style="width: 25px; vertical-align: bottom; margin-right: 5px;">Auditorium
                                            PT PLN<br>
                                            <span style="font-size: 12px;">Jalan Trunojoyo Blok M I No.135, Gedung
                                                Kantor
                                                Pusat PT. PLN (Persero), Kebayoran Baru, RT.6/RW.2, Melawai, Kec. Kby.
                                                Baru,
                                                Kota Jakarta Selatan, Daerah Khusus Ibukota Jakarta 12160</span>
                                        </p>
                                        <p
                                            style="font-size: 18px; margin-bottom: 10px; text-indent: -30px; padding-left: 30px; line-height: 1;">
                                            <img src="{{ asset('images/icons/ic-calendar.png') }} " alt=""
                                                style="width: 25px; vertical-align: bottom;  margin-right: 5px;">Sabtu,
                                            24
                                            Juni 2023
                                        </p>
                                        <p
                                            style="font-size: 18px; margin-bottom: 10px; text-indent: -30px; padding-left: 30px; line-height: 1;">
                                            <img src="{{ asset('images/icons/ic-clock.png') }}" alt=""
                                                style="width: 25px; vertical-align: bottom;  margin-right: 5px;">09.00
                                            WIB
                                        </p>
                                        <table role="presentation" border="0" cellpadding="0" cellspacing="0" align="center">
                                            <tbody>
                                                <tr>
                                                    <td align="left">
                                                        <table role="presentation" border="0" cellpadding="0"
                                                            cellspacing="0">
                                                            <tbody>
                                                                <tr>
                                                                    <img src="data:image/png;base64,{{ base64_encode($imageQrRsvp) }}"
                                                                        alt="QR Image RSVP" style="width: 120px">
                                                                </tr>
                                                            </tbody>
                                                        </table>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                        <p>&nbsp;</p>
                                        <p align="center">Nama : {{ $member_name }}</p>
                                        <p align="center">Nosis : {{ $member_nosis }}</p>
                                        <p align="center">Batch : {{ $member_batch }}</p>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>

                    <!-- END MAIN CONTENT AREA -->
                </table>
                <!-- END CENTERED WHITE CONTAINER -->


                <div>
                    <a href="{{ route('home') }}" class="btn btn-default">Kembali Ke Home</a>
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
