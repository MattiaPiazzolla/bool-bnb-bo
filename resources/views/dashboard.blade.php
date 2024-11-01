@extends('layouts.app')

@section('content')
    <div class="wrapper">
        <!--sidebar-->
        <div class="side-bar d-flex flex-column justify-content-between py-5">
            <!--sezione menu-->
            <ul class="text-white d-flex flex-column list-unstyled gap-3 py-5">
                <li><a href="#">I tuoi annunci</a></li>
                <li><a href="#">Metti in evidenza</a></li>
                <li><a href="#">Messaggi</a></li>
                <li><a href="#">Statistiche</a></li>
            </ul>

            <div class="bottom-menu d-flex flex-column justify-content-center">
                <!--menu d'accesso al logout rapido e al proprio profilo direttamente in sidebar-->
                    <div class="img-box mb-2">
                        <img src="https://cdn.pixabay.com/photo/2016/08/08/09/17/avatar-1577909_960_720.png" alt="asd">
                    </div>
                    <span>User-001</span>
                    <a href="#">Logout</a>
            </div>
        </div>

        <div>
        <!--Sezione dedicata allo yield. Qui vedrai tutto il contenuto effettivo della dashboard-->
        @yield('content')
        </div> 
    </div>
@endsection
