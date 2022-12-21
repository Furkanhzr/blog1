<?php

use App\Http\Controllers\Back\ConfigController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Front\HomePage;
use App\Http\Controllers\Back\Dashboard;
use App\Http\Controllers\Back\AuthController;
use App\Http\Controllers\Back\ArticleController;
use App\Http\Controllers\Back\CategoryController;
use App\Http\Controllers\Back\PageController;

/*
-----------------------------
    Back Routes
-----------------------------
*/

Route::prefix('admin')->name('admin.')->middleware('isLogin')->group(function() {
    Route::get('/giris',[AuthController::class, 'login'])->name('login');
    Route::post('/giris',[AuthController::class, 'loginPost'])->name('login.post');
});


// name('admin.') sayesinde örneğin name('admin.dashboard') gibi name'lerde başlarına admin. yazmamıza gerek kalmayacak.
Route::prefix('admin')->name('admin.')->middleware('isAdmin')->group(function() {
    Route::get('/panel',[Dashboard::class, 'index'])->name('dashboard');
    //MAKALE ROUTE'S
    Route::get('/makaleler/silinenler', [ArticleController::class, 'trashed'])->name('trashed.article');
    Route::resource('makaleler',ArticleController::class);
    Route::get('/switch',[ArticleController::class, 'switch'])->name('switch');
    Route::get('/deletearticle/{id}',[ArticleController::class, 'delete'])->name('delete.article');
    Route::get('/harddeletearticle/{id}',[ArticleController::class, 'hardDelete'])->name('hard.delete.article');
    Route::get('/recoverarticle/{id}',[ArticleController::class, 'recover'])->name('recover.article');
    //CATEGORY ROUTE'S
    Route::get('/kategoriler',[CategoryController::class, 'index'])->name('category.index');
    Route::post('/kategoriler/create',[CategoryController::class, 'create'])->name('category.create');
    Route::post('/kategoriler/update',[CategoryController::class, 'update'])->name('category.update');
    Route::post('/kategoriler/delete',[CategoryController::class, 'delete'])->name('category.delete');
    Route::get('/kategori/status',[CategoryController::class, 'switch'])->name('category.switch');
    Route::get('/kategori/getData',[CategoryController::class, 'getData'])->name('category.getdata');
    //PAGE'S ROUTE
    Route::get('/sayfalar',[PageController::class, 'index'])->name('page.index');
    Route::get('/sayfalar/oluştur',[PageController::class, 'create'])->name('page.create');
    Route::post('/sayfalar/oluştur',[PageController::class, 'createPost'])->name('page.create.post');
    Route::get('/sayfalar/guncelle/{id}',[PageController::class, 'update'])->name('page.edit');
    Route::post('/sayfalar/guncelle/{id}',[PageController::class, 'updatePost'])->name('page.edit.post');
    Route::get('/sayfalar/sil/{id}',[PageController::class, 'delete'])->name('page.delete');
    Route::get('/sayfalar/siralama',[PageController::class, 'orders'])->name('page.orders');
    Route::get('/sayfalar/status',[PageController::class, 'switch'])->name('page.switch');
    //CONFİG'S ROUTE
    Route::get('/ayarlar', [ConfigController::class, 'index'])->name('config.index');
    Route::post('/ayarlar/update', [ConfigController::class, 'update'])->name('config.update');
    //
    Route::get('/cikis', [AuthController::class, 'logout'])->name('logout');
});



/*
-----------------------------
    Front Routes
-----------------------------
*/

Route::get('/',[HomePage::class, 'index'])->name('homepage');
Route::get('/sayfa',[HomePage::class, 'index']);
Route::get('/iletisim',[HomePage::class, 'contact'])->name('contact');//sabit verdiğimiz url leri başta tanımlamamız gerek
                            //örenğin eğer {sayfa} gibi parametre alan ifadelerin altına koyarsa / dan sonra değer aradığı için
                            //404 not found hatası verir bunun önüne geçmek için üste yazarız.
Route::post('/iletisim',[HomePage::class, 'contactpost'])->name('contact.post');
Route::get('/kategori/{category}',[HomePage::class, 'category'])->name('category');
Route::get('/{category}/{slug}',[HomePage::class, 'single'])->name('single');
Route::get('/{sayfa}',[HomePage::class, 'page'])->name('page');





