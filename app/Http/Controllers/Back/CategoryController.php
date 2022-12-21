<?php

namespace App\Http\Controllers\Back;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Category;
use Illuminate\Support\Str;
use App\Models\Article;

class CategoryController extends Controller
{
    public function index() {
        $admin = Auth::user();
        $categories = Category::all();
        return view('back.categories.index',compact('admin','categories'));
    }

    public function switch(Request $request) {
        $category=Category::findOrFail($request->id);
        $category->status=$request->statu=='true' ? 1 : 0;
        $category->save();
    }

    public function create(Request $request) {
        $isExist = Category::whereSlug(Str::slug($request->category))->first();
        if($isExist) {
            toastr()->error($request->category." adında bir kategori zaten mevcut!","Hata");
            return redirect()->back();
        }
        $category = new Category();
        $category->name = $request->category;
        $category->slug = Str::slug($request->category);
        $category->save();
        toastr()->success('Kategori başarıyla oluşturuldu','Başarılı');
        return redirect()->back();
    }

    public function delete(Request $request) {
        $category = Category::findOrFail($request->id);
        if ($category->id == 1) {
            toastr()->error('Bu kategori silinemez','Hata');
            return redirect()->back();
        }
        $message='';
        $count = $category->articleCount();
        if($count > 0) {
            Article::where('category_id',$category->id)->update(['category_id'=>1]);//category_id si kategorinin id'si olan makaleyi bul.
            $defaultCategory=Category::find(1);
            $message = 'bu kategoriye ait '.$count.' makale '.$defaultCategory->name.' kategorisine taşındı';
        }
        $category->delete();
        toastr()->success('Bu kategori başarıyla silindi '.$message,'Başarılı');
        return redirect()->back();
    }

    public function getData(Request $request) {
        $category=Category::findOrFail($request->id);//request ile id yi yakalicaz ve kategoriyi bulacak ve kategoriyi bulursa
        return response()->json($category); // sonrada bu bulduğu kategoriyi bize göndermesi json olarak geri döndersin
                                            //var olan kategoriyi bize gönderiyor

    }

    public function update(Request $request) {
        $isSlug = Category::whereSlug(Str::slug($request->slug))->whereNotIn('id',[$request->id])->first();//slug'ı kontrol ediyoruz
        $isName = Category::whereName($request->category)->whereNotIn('id',[$request->id])->first();//kategori ismini kontrol ediyoruz
        //->whereNotIn('id',[$request->id]) güncellen id dışındaki id'leri kontrol etsin
        //bu sayede bir kategorinin slug değerini veya ismini aynı isimde güncelleyince
        // zaten bu kategori var hatası almayız

        if($isSlug or $isName) { //aynı slug veya name varsa hatayı bassın
            toastr()->error($request->category." adında bir kategori zaten mevcut!","Hata");
            return redirect()->back();
        }

        $category = Category::find($request->id);
        $category->name = $request->category;
        $category->slug = Str::slug($request->slug);
        $category->save();
        toastr()->success('Kategori başarıyla güncellendi','Başarılı');
        return redirect()->back();
    }


}
