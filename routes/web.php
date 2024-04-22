<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\RolesController;
use App\Models\User;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::get('/register', [AuthController::class, 'showSignupForm'])->name('register');
Route::post('/register', [AuthController::class, 'signup']); 
Route::get('/logout', [AuthController::class, 'logout'])->name('logout');
Route::get('/dashboard/admin', [AuthController::class, 'index'])->name('dashboard.admin');
Route::get('/dashboard/categories', [CategoryController::class, 'index'])->name('categories.index');
Route::delete('/categories/{category}', [CategoryController::class, 'destroy'])->name('categories.destroy');
Route::get('/dashboard/roles', [RolesController::class, 'index'])->name('roles.index');
Route::post('/dashboard/categories', [CategoryController::class, 'store'])->name('categories.store');
Route::put('/dashboard/categories/{id}', [CategoryController::class, 'update'])->name('categories.update'); // Changed route name
Route::delete('/categories/{category}', [CategoryController::class, 'destroy'])->name('categories.destroy');
Route::get('/dashboard/seller', [ProductController::class, 'index'])->name('dashboard.seller');
Route::post('/dashboard/seller/store', [ProductController::class, 'store'])->name('seller.store');
Route::delete('/products/{product}', [ProductController::class, 'destroy'])->name('products.destroy');
Route::get('/dashboard/roles', [RolesController::class, 'index'])->name('dashboard.roles');
Route::delete('/dashboard/roles/{user}', [RolesController::class,'destroy'])->name('users.destroy');
Route::put('/dashboard/roles/{user}', [RolesController::class,'update'])->name('users.update');
Route::get('/home', [ProductController::class, 'home'])->name('home');
Route::get('/detail/{id}', [ProductController::class, 'detail'])->name('detail');
Route::post('/cart/add/{product}', [ProductController::class, 'addToCart'])->name('cart.add');