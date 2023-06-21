@extends('layouts.noheader')

@section('content')
<style>
    body{
        background-color: #4478bd;
    }
    #loginbox{
        margin-top: 40px;
    }
</style>
<div class="container">    
    <div class="row" id="loginbox">
        <div class="col-md-4 col-md-offset-4">
            <div class="login panel panel-default">
                <div class="panel-heading">                                
                    <div class="row-fluid user-row">
                        <img src="{{ asset('images/login-logo.png') }}" class="img-responsive" alt="Database Ikastara"/>
                    </div>
                </div>
                <div class="panel-body">
                    <form class="form-horizontal" role="form" method="POST" action="{{ route('login') }}">
                        {{ csrf_field() }}
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
                            <input class="form-control" placeholder="Username" id="username" type="text" class="form-control" name="username" value="{{ old('username') }}" required autofocus>
                            <input class="form-control" placeholder="Password" id="password" type="password" class="form-control" name="password" required>
                            <div class="form-group">
                                <div class="col-md-6">
                                    <div class="checkbox">
                                        <label>
                                            <input type="checkbox" name="remember" {{ old('remember') ? 'checked' : '' }}> Ingat Saya
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <input class="btn btn-lg btn-success btn-block" type="submit" id="login" value="Login »">
                            <a class="btn btn-link" href="{{ route('password.request') }}">
                                Lupa Password?
                            </a>
                            <a class="btn btn-lg btn-warning btn-block" type="button" href="{{ url('/register') }}" id="register">Daftar</a>
                            <!-- social login-->
                            <!--br/>
                            <a class="btn btn-social btn-google-plus btn-block" href="redirect/facebook">
                                <i class="fa fa-google"></i> Login dengan Google
                            </a>
                            <a class="btn btn-social btn-facebook btn-block" href="redirect/facebook">
                                <i class="fa fa-facebook"></i> Login dengan Facebook
                            </a>
                            <a class="btn btn-social btn-twitter btn-block" href="redirect/twitter">
                                <i class="fa fa-twitter"></i> Login dengan Twitter
                            </a-->
                        </fieldset>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
