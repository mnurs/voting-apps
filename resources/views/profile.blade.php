@include('include/header')

<body>
    <div id="app">

        @include('include/navbar')

        <div id="plktm">
            <div class="container">
                <div class="pfl">
                    <h3>Data Pemilih</h3>
                    <div class="pfl-img">
                        <img src="https://placehold.co/300x400" alt="">
                    </div>
                    <div class="pfl-data">
                        <ul>
                            <li>[Nama]</li>
                            <li>[Nosis]</li>
                            <li>[Angkatan]</li>
                            <li>[Email]</li>
                            <li>[No. Whatsapp]</li>
                        </ul>
                    </div>

                    <div class="pfl-btn btn-cont">
                        <button class="btn btn-success">Konfirmasi Kehadiran</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @include('include/footer')
</body>

</html>
