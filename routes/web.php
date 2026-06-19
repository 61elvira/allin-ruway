<?php

use Illuminate\Support\Facades\Route;

Route::view('/', 'home');

Route::view('/login', 'login');

Route::view('/register', 'register');

Route::view('/register/cliente', 'register-cliente');

Route::view('/register/trabajador', 'register-trabajador');