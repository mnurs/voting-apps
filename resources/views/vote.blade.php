@include('include/header')

<body>
    <div id="app">
        @include('include/navbar')

        <div id="plktm">
            <div class="container">
                <h1 class="text-center">Tentukan Pilihan Anda!</h1>
                @if (session('not_yet_choose_candidate'))
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        {{ session('not_yet_choose_candidate') }}
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                @endif

                <form action="{{ route('vote_candidate_store') }}" method="POST" role="form">
                    @csrf
                    <div class="list-vote">
                        <div class="row mb-2">
                            @foreach ($candidates as $candidate)
                                <div class="col-md-3 col-xs-6">
                                    <div class="radio">
                                        <label for="vote-ketum-{{ $candidate->number }}">
                                            <input type="radio" name="vote_ketum" id="vote-ketum-{{ $candidate->number }}"
                                                value="{{ $candidate->id }}"
                                                {{ session()->get('vote.candidate_choosen.candidate_id') == $candidate->id ? 'selected' : '' }}
                                                required>
                                            <div class="it">
                                                <div class="img">
                                                    <img src="{{ asset("uploads/candidate/{$candidate->photo}") }}"
                                                        alt="">
                                                </div>
                                                <div class="txt">
                                                    <h3>{{ $candidate->name }}</h3>
                                                    <h3>{{ $candidate->candidate_batch }}</h3>
                                                </div>
                                            </div>
                                        </label>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        <div class="form-group btn-cont text-right">
                            <button type="submit" class="btn btn-default">Selanjutnya</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    @include('include/footer')
</body>

</html>
