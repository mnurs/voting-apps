@include('include/header')

<style>
    body {
        background-color: #4478bd;
    }

    #loginbox {
        margin-top: 40px;
    }
</style>


<body>
    <div id="app">
        <div id="plktm">
            <div class="container">
                <div class="row" id="loginbox">
                    <div class="col-md-4 col-md-offset-4">
                        <div class="login panel panel-default">
                            <div class="panel-heading">
                                <div class="row-fluid user-row">
                                    <img src="{{ asset('images/logo/evotinglogo.png') }}" class="img-responsive"
                                        alt="E-Voting Database Ikastara" style="margin: 0 auto" />
                                </div>
                            </div>
                            <div class="panel-body">
                                <form class="form-horizontal" role="form" method="POST"
                                    action="{{ route('login') }}">
                                    @csrf
                                    <fieldset>
                                        <label class="panel-login">
                                            <div class="login_result">
                                                @if ($errors->has('username'))
                                                    <span class="help-block">
                                                        <strong>{{ $errors->first('username') }}</strong>
                                                    </span>
                                                @endif
                                                @if ($errors->has('password'))
                                                    <span class="help-block">
                                                        <strong>{{ $errors->first('password') }}</strong>
                                                    </span>
                                                @endif
                                            </div>
                                        </label>
                                        <input class="form-control" placeholder="Username" id="username" type="text"
                                            class="form-control" name="username" value="{{ old('username') }}" required
                                            autofocus autocomplete="off">
                                        <input class="form-control" placeholder="Password" id="password"
                                            type="password" class="form-control" name="password" required
                                            autocomplete="off">
                                        <input class="form-control"  id="bag_id" type="hidden" class="form-control" name="bag_id">
                                        <input class="btn btn-lg btn-success btn-block" type="submit" id="login"
                                            value="Login »">
                                    </fieldset>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

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
    @include('include/footer')
</body>

</html>
