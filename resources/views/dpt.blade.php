@include('include/header')

<body>
    <div id="app">

        @include('include/navbar')

        <div id="plktm">
            <div class="container">
                <div class="sbt">
                    <div class="sbt-top mb-4">
                        <h3 class="text-center mb-4">Daftar Pemilih Tetap</h3>

                        <p class="text-center">
                            Silahkan isi data di bawah ini, dan pastikan data tersebut adalah benar untuk menjadi
                            dikukuhkan menjadi Daftar Pemilih Tetap dalam Pemilihan Ketua Umum Ikastara 2023/2026
                        </p>
                    </div>

                    <div class="sbt-bd">
                        <h3 class="mb-2">Data Pemilih</h3>
                        <form id="form_dpt" action="{{ route('dpt_store') }}" method="POST" role="form" enctype="multipart/form-data">
                            @csrf
                            <div class="sbt-form">
                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-xs-4">
                                            <label for="sbt-name">Nama</label>
                                        </div>
                                        <div class="col-xs-8">
                                            <input type="text" class="form-control" id="sbt-name" value="{{ $member->name }}" readonly>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-xs-4">
                                            <label for="sbt-nosis">Nosis</label>
                                        </div>
                                        <div class="col-xs-8">
                                            <input type="text" class="form-control" id="sbt-nosis"
                                                value="{{ $member->nosis }}" readonly>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-xs-4">
                                            <label for="sbt-class">Angkatan</label>
                                        </div>
                                        <div class="col-xs-8">
                                            <input type="text" class="form-control" id="sbt-class" value="{{ $batch_name }}" readonly>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-xs-4">
                                            <label for="sbt-email">Email</label>
                                        </div>
                                        <div class="col-xs-8">
                                            <input type="email" class="form-control" id="sbt-email" name="email" required autocomplete="off">
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-xs-4">
                                            <label for="sbt-wa">No. Whatsapp</label>
                                        </div>
                                        <div class="col-xs-8">
                                            <input type="number" class="form-control" id="sbt-wa" name="no_whatsapp" required autocomplete="off">
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-xs-4">
                                            <label for="sbt-photo">Unggah Foto Selfie</label>
                                        </div>
                                        <div class="col-xs-8">
                                            <div class="form-file-cont mb-2">
                                                <label for="sbt-photo">
                                                    <span>No file choosen</span>
                                                    <i class="fa fa-camera" aria-hidden="true"></i>
                                                </label>
                                                <small class="text-red">Maksimal upload 5MB</small>
                                                <input class="form-file" id="sbt-photo" name="dpt_photo"
                                                    type="file" accept="image/.JPEG, .HEIC, .HEIF, .JPG" capture="camera" required>
                                            </div>
                                            <img id="sbt-preview" src="#" alt="">
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="bs-callout bs-callout-primary text-center">
                                        <label>
                                            <p>Notes : Foto diri harus menampakkan seluruh wajah serta tangan kiri yang membentuk angka 5</h4>
                                        </label>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="checkbox">
                                        <label>
                                            <input type="checkbox" required> Saya menyatakan bahwa data tersebut di atas adalah
                                            benar data pilihan saya
                                        </label>
                                    </div>
                                </div>

                                <div class="form-group btn-cont text-right">
                                    <button id="submit_dpt" type="submit" class="btn btn-default">Submit DPT</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @include('include/footer')
</body>

</html>
