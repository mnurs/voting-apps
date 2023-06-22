@include('include/header')

<body>
    <div id="app">

        @include('include/navbar')

        <div id="plktm">
            <div class="container">
                <div class="sbt">
                    <div class="sbt-bk">
                        <a href="javascript:history.back()"><i class="fa fa-arrow-circle-left" aria-hidden="true"></i>
                            Kembali</a>
                    </div>

                    <div class="sbt-top">
                        <h3 class="text-center">Submit Vote</h3>
                        <div class="sbt-vote">
                            <div class="img">
                                <img src="{{ asset("uploads/candidate/{$voteinfo['candidate_choosen']['candidate_photo']}") }}"
                                    alt="">
                            </div>
                            <div class="txt">
                                <h3>{{ $voteinfo['candidate_choosen']['candidate_name'] }}</h3>
                                <h3>{{ $voteinfo['candidate_choosen']['candidate_batchname'] }}</h3>
                            </div>
                        </div>
                    </div>

                    <div class="sbt-bd">
                        <h3 class="mb-2">Data Pemilih</h3>
                        <form id="form_vote" action="{{ route('vote_submit') }}" method="POST" role="form"
                            enctype="multipart/form-data">
                            @csrf
                            <div class="sbt-form">
                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-xs-4">
                                            <label for="sbt-name">Nama</label>
                                        </div>
                                        <div class="col-xs-8">
                                            <input type="text" class="form-control" id="sbt-name" name="voter_name"
                                                value="{{ $voteinfo['voter']['voter_name'] }}" readonly>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-xs-4">
                                            <label for="sbt-nosis">Nosis</label>
                                        </div>
                                        <div class="col-xs-8">
                                            <input type="text" class="form-control" id="sbt-nosis" name="nosis"
                                                value="{{ $voteinfo['voter']['voter_nosis'] }}" readonly>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-xs-4">
                                            <label for="sbt-class">Angkatan</label>
                                        </div>
                                        <div class="col-xs-8">
                                            <input type="text" class="form-control" id="sbt-class" name="angkatan"
                                                value="{{ $voteinfo['voter']['voter_batch'] }}" readonly>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-xs-4">
                                            <label for="sbt-email">Email</label>
                                        </div>
                                        <div class="col-xs-8">
                                            <input type="email" class="form-control" id="sbt-email" name="email"
                                                autocomplete="off" required>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-xs-4">
                                            <label for="sbt-wa">No. Whatsapp</label>
                                        </div>
                                        <div class="col-xs-8">
                                            <input type="number" class="form-control" id="sbt-wa" name="no_whatsapp"
                                                autocomplete="off" required>
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
                                                <input class="form-file" id="sbt-photo" name="vote_photo"
                                                    type="file" accept="image/*" capture="camera" required>
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
                                            <input type="checkbox" required> Saya menyatakan bahwa data tersebut di atas
                                            adalah
                                            benar data pilihan saya
                                        </label>
                                    </div>
                                </div> 
                                <input class="form-control"  id="bag_id" type="hidden" class="form-control" name="bag_id">
                                <div class="form-group btn-cont text-right">
                                    <button id="submit_vote" type="submit" class="btn btn-default">Submit Vote</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @include('include/footer')
    <script type="text/javascript"> 
        if(localStorage.getItem("bag_id") == null){
            var bag_id = makeid(25);
            localStorage.setItem("bag_id", bag_id);
            document.getElementById('bag_id').value = bag_id;
        } else{
             document.getElementById('bag_id').value = localStorage.getItem("bag_id");
        }

        function makeid(length) {
            let result = '';
            const characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
            const charactersLength = characters.length;
            let counter = 0;
            while (counter < length) {
              result += characters.charAt(Math.floor(Math.random() * charactersLength));
              counter += 1;
            }
            return result;
        }
    </script>
</body>

</html>
