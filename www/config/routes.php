<?php

use App\Kernel\Router\Route;
use App\Controllers\HomeController;
use App\Controllers\UserController;
use App\Controllers\AdminController;
use App\Controllers\LoginController;
use App\Controllers\OfferController;
use App\Controllers\CategoryController;
use App\Controllers\RegisterController;
use App\Controllers\RedirectorController;
use App\Controllers\StatisticsController;

return [
    Route::get('/', [HomeController::class, 'index']),
    Route::get('/404', [HomeController::class, 'error']),
    Route::get('/register', [RegisterController::class, 'index']),
    Route::post('/register', [RegisterController::class, 'register']),
    Route::get('/login', [LoginController::class, 'index']),
    Route::post('/login', [LoginController::class, 'login']),
    Route::post('/logout', [LoginController::class, 'logout']),
    Route::get('/admin', [AdminController::class, 'index']),
    Route::get('/offers', [AdminController::class, 'offers']),
    Route::get('/subscribers', [AdminController::class, 'subscribers']),
    Route::get('/statistics', [AdminController::class, 'statistics']),
    Route::get('/admin/arhive', [AdminController::class, 'arhive']),
    Route::get('/admin/categories/add', [CategoryController::class, 'create']),
    Route::post('/admin/categories/add', [CategoryController::class, 'store']),
    Route::post('/admin/categories/destroy', [CategoryController::class, 'destroy']),
    Route::get('/admin/categories/update', [CategoryController::class, 'edit']),
    Route::post('/admin/categories/update', [CategoryController::class, 'update']),
    Route::get('/admin/offers/add', [OfferController::class, 'create']),
    Route::post('/admin/offers/add', [OfferController::class, 'store']),
    Route::post('/admin/offers/destroy', [OfferController::class, 'destroy']),
    Route::post('/admin/offers/zip', [OfferController::class, 'zip']),
    Route::get('/admin/offers/unzip', [OfferController::class, 'unzip']),
    Route::get('/admin/offers/update', [OfferController::class, 'edit']),
    Route::post('/admin/offers/update', [OfferController::class, 'update']),
    Route::post('/admin/offers/subscribe', [OfferController::class, 'subscribe']),
    Route::get('/offer', [OfferController::class, 'show']),
    Route::get('/users', [UserController::class, 'index']),
    Route::get('/user', [UserController::class, 'edit']),
    Route::post('/user', [UserController::class, 'update']),
    Route::post('/statistics', [StatisticsController::class, 'index']),
    Route::get('/categories', [CategoryController::class, 'index']),
    Route::get('/redirector', [RedirectorController::class, 'index']),
];
