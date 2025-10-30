
@extends('layouts.default')
@section('title','Page de création de compte')
@section('content')
    @include("partials/header")
    @section('css',asset('css/signIn(Up).css'))
    <div class="container">
        <div class="wrapper">
            <form action="{{route('signup')}}" method="POST">
                @csrf
                <h1>Création de compte</h1>
                <div class="input-box">
                    <input type="text" name="userName" placeholder="Alias" value="{{old('userName')}}"
                           required>
                </div>
                <div class="input-box"><input type="password" name="password" placeholder="Mot de passe" required>
                </div>
                <div class="input-box"><input type="password" name="confirmPassword" placeholder="Confirmer mot de passe" required>
                </div>
                <button type="submit" class="btn">S'enregistrer</button>

                <div class="register-redirect"><p>Déjà un compte ? <a href="/login">Se connecter</a></p>
                </div>

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

