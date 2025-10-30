<?php

use App\Http\Controllers\Authentication\LoginController;
use App\Http\Controllers\Authentication\LogoutController;
use App\Http\Controllers\Authentication\SignupController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\BackpackController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\EnigmaController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ItemController;


Route::get('/',[ItemController::class,'index']);
//--------------------Authentication--------------------
Route::get('/login',[LoginController::class, 'showLogin'])->name('show.login');
Route::post('/login',[LoginController::class, 'login'])->name('login');
Route::post('/logout',[LogoutController::class,'logout'])->name('logout');
Route::get('/signup',[SignupController::class,'showSignup'])->name('show.signup');
Route::post('/signup',[SignupController::class,'signup'])->name('signup');

Route::get('/logout', function () {
    return redirect()->route('item.index');
});

//--------------------Item--------------------
Route::get('/item',[ItemController::class,'index'])->name('item.index');
Route::get('/item/{id}',[ItemController::class,'details'])->name('item.details');

//--------------------Cart--------------------
Route::get('/cart',[CartController::class,'index'])->name('cart.index');
Route::post('/cart/add',[CartController::class,'addCart'])->name('add.cart');
Route::post('/cart/pay',[CartController::class,'payCart'])->name('pay.cart');
Route::post('/cart/modify',[CartController::class,'modifyItemQuantity'])->name('modify.cart');
Route::post('/cart/empty',[CartController::class,'emptyCart'])->name('empty.cart');

Route::get('/cart/add', function () {
    return redirect()->route('cart.index');
});
Route::get('/cart/pay', function () {
    return redirect()->route('cart.index');
});
Route::get('/cart/modify', function () {
    return redirect()->route('cart.index');
});
Route::get('/cart/empty', function () {
    return redirect()->route('cart.index');
});

//--------------------Comment---------------------
Route::post('/addComment',[CommentController::class,'addComment'])->name('add.comment');
Route::post('/removeComment',[CommentController::class,'removeComment'])->name('remove.comment');

Route::get('/addComment', function () {
    return redirect()->route('item.index');
});
Route::get('/removeComment', function () {
    return redirect()->route('item.index');
});

//--------------------Backpack--------------------
Route::get('/backpack',[BackpackController::class,'index'])->name('backpack.index');
Route::get('/backpack/{id}',[BackpackController::class,'details'])->name('backpack.details');
Route::post('/backpack/consume',[BackpackController::class,'consume'])->name('consume.backpack');
Route::post('/backpack/sell',[BackpackController::class,'sell'])->name('sell.backpack');
Route::post('/backpack/throw',[BackpackController::class,'throw'])->name('throw.backpack');


Route::get('/backpack/consume', function () {
    return redirect()->route('backpack.index');
});
Route::get('/backpack/sell', function () {
    return redirect()->route('backpack.index');
});

Route::get('/backpack/throw', function () {
    return redirect()->route('backpack.index');
});

//--------------------Enigma--------------------
Route::get('/enigma',[EnigmaController::class,'index'])->name('enigma.index');
Route::get('/enigma/test',[EnigmaController::class,'test'])->name('enigma.test');
Route::post('/enigma/quiz',[EnigmaController::class,'quiz'])->name('enigma.quiz');
Route::post('/enigma/result',[EnigmaController::class,'result'])->name('enigma.result');

Route::get('/enigma/quiz', function () {
    return redirect()->route('enigma.index');
});
Route::get('/enigma/result', function () {
    return redirect()->route('enigma.index');
});

//--------------------Admin--------------------
Route::get('/admin',[AdminController::class,'index'])->name('admin.index');
Route::get('/admin/comment', [AdminController::class, 'comment'])->name('admin.comment');
Route::post('/admin/addCaps',[AdminController::class,'addCaps'])->name('admin.addCaps');

Route::get('/admin/addCaps', function () {
    return redirect()->route('admin.index');
});

Route::view('/app', 'layouts.app')->name('app');
Route::view('/popUpAchat', 'cart.popUpAchat')->name('popUpAchat');
Route::view('/vendrePopUp', 'partials.vendrePopUp')->name('vendrePopUp');


//Route::get('/insert-user', [LoginController::class, 'insertTestUser']);

