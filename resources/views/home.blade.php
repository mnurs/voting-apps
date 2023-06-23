@include('include/header')

<body>
    <div id="app">

        @include('include/navbar')

        <div id="plktm">
            <div class="container">
                {{-- notification --}}
                @if ($message = Session::get('not-eligible'))
                    <div class="alert alert-danger alert-block">
                        <button type="button" class="close" data-dismiss="alert">×</button>
                        <strong>{{ $message }}</strong>
                    </div>
                @endif

                @if ($message = Session::get('vote-has-not-started-yet'))
                    <div class="alert alert-info alert-block">
                        <button type="button" class="close" data-dismiss="alert">×</button>
                        <strong>{{ $message }}</strong>
                    </div>
                @endif

                @if ($message = Session::get('time-dpt-has-expired'))
                    <div class="alert alert-info alert-block">
                        <button type="button" class="close" data-dismiss="alert">×</button>
                        <strong>{{ $message }}</strong>
                    </div>
                @endif

                @if ($message = Session::get('user-has-vote'))
                    <div class="alert alert-danger alert-block">
                        <button type="button" class="close" data-dismiss="alert">×</button>
                        <strong>{{ $message }}</strong>
                    </div>
                @endif


                <div class="countdown-cont mt-5">
                    <h4 class="text-center">Countdown to MUNAS</h4>
                    <div id="countdown"></div>
                </div>

                @if ($btnDpt)
                    <div>
                        <a href="{{ route('dpt') }}" class="btn btn-danger mb-4">Daftar Pemilih Tetap</a>
                    </div>
                @endif

                @if ($btnVote)
                    <div>
                        <h4 class="text-danger text-center">Voting Dimulai Pada 23-06-2023 09:00:00 dan berakhir
                            pada
                            24-06-2023 09:00:00</h4>
                        <a href="{{ route('vote_candidate') }}" class="btn btn-danger mb-4">
                            VOTE DI SINI
                        </a>
                    </div>
                @else
                    {{-- btn disabled --}}
                    <div>
                        <div>
                            <h4 class="text-danger text-center">Voting Dimulai Pada 23-06-2023 09:00:00 dan berakhir
                                pada
                                24-06-2023 09:00:00</h4>
                        </div>
                        <a href="javascript:void(0)" class="btn btn-danger mb-4" disabled>
                            @if ($labelBtnHasVote)
                                ANDA SUDAH VOTING
                            @else
                                VOTE DI SINI
                            @endif
                        </a>
                    </div>
                @endif

                @if ($btnRsvp)
                    <div>
                        <a href="{{ route('rsvp') }}" class="btn btn-success">REGISTRASI KEHADIRAN MUNAS</a>
                    </div>
                @endif
                @if ($btnMyRsvpPage)
                    <div>
                        <a href="{{ route('my_rsvp') }}" class="btn btn-success">Periksa RSVP Munas Anda</a>
                    </div>
                @endif
            </div>
        </div>
    </div>

    @include('include/footer')

</body>

<script type="text/javascript">
    $("#btnVoteDisabled *").attr("disabled", "disabled").off('click');
</script>

</html>
