<?php

use Src\Route;

// Public
Route::add('GET', '/', [Controller\TelephonyController::class, 'index']);
Route::add(['GET', 'POST'], '/login', [Controller\Site::class, 'login']);

// Auth
Route::add('GET', '/logout', [Controller\Site::class, 'logout'])->middleware('auth');

// System admin area
Route::add(['GET', 'POST'], '/divisions', [Controller\TelephonyController::class, 'divisions'])->middleware('auth', 'role:sysadmin,admin');
Route::add(['GET', 'POST'], '/premises', [Controller\TelephonyController::class, 'premises'])->middleware('auth', 'role:sysadmin,admin');
Route::add(['GET', 'POST'], '/phones', [Controller\TelephonyController::class, 'phones'])->middleware('auth', 'role:sysadmin,admin');
Route::add(['GET', 'POST'], '/subscribers', [Controller\TelephonyController::class, 'subscribers'])->middleware('auth', 'role:sysadmin,admin');
Route::add(['GET', 'POST'], '/assign-phone', [Controller\TelephonyController::class, 'assignPhone'])->middleware('auth', 'role:sysadmin,admin');
Route::add(['GET', 'POST'], '/reports', [Controller\TelephonyController::class, 'reports'])->middleware('auth', 'role:sysadmin,admin');

// Admin area: create sysadmins
Route::add(['GET', 'POST'], '/admin/sysadmins', [Controller\AdminController::class, 'sysadmins'])->middleware('auth', 'role:admin');