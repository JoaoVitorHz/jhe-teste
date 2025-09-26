<?php

use App\Http\Controllers\ClientController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::post('/clientes', [ClientController::class, 'CreateClient']);
Route::get('/clientes', [ClientController::class, 'GetAllClients']);
