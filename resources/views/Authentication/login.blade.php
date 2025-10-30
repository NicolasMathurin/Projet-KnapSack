
@extends('layouts.default')
@section('title','Page de connexion')
@section('content')
    @include("partials/header")
@section('css',asset('css/signIn(Up).css'))
    <div class="container">
        <div class="wrapper">
            <form action="{{route('login')}}" method="POST">
                @csrf
                <h1>Connexion</h1>
                <div class="input-box">
                    <input type="text" name="userName" placeholder="Alias" value="{{old('userName')}}"
                           required>
                </div>
                <div class="input-box"><input type="password" name="password" placeholder="Mot de passe" required>
                </div>
                <div class="remember-forgot"><label><input type="checkbox" name="remember">Se souvenir</label>
                </div>
                <button type="submit" class="btn">Se connecter</button>

                <div class="register-redirect"><p>Pas de compte ? <a href="/signup">{{__('Créer un compte')}}</a></p>
                </div>
                @if (session('message-sucess'))
                    <div  class="text-success">>
                        {{ session('message-sucess') }}
                    </div>
                @endif
                @if (session('message-error'))
                    <div  class="text-danger">>
                        {{ session('message-error') }}
                    </div>
                @endif
                @if ($errors->any())
                    <ul class="px-4 py-2 bg-red-100">
                        @foreach ($errors->all() as $error)
                            <li class="text-danger">{{ $error }}</li>
                        @endforeach
                    </ul>
                @endif

            </form>
        </div>
    </div>
@endsection

