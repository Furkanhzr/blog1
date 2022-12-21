<?php

namespace App\Http\Controllers\Back;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Page;
use App\Models\Admin;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class PageController extends Controller
{
    public function index() {
        $pages=Page::all();
        $admin=Auth::user();
        return view('back.pages.index',compact('pages','admin'));
    }

    public function switch(Request $request) {
        $page = Page::findOrFail($request->id);
        $page->status=$request->statu=='true' ? 1 : 0;
        $page->save();
    }

    public function create() {
        $admin = Auth::user();
        return view('back.pages.create',compact('admin'));
    }

    public function createPost(Request $request) {
        $request->validate([
            'title'=>'min:3',
            'image' =>'required|image|mimes:jpeg,jpg,png|max:2048'
        ]);

        $last = Page::all()->last();

        $page = new Page;
        $page->title = $request->title;
        $page->content = $request->contentt;
        $page->order = $last->order+1;
        $page->slug = Str::slug($request->title);

        if ($request->hasFile('image')) {
            $imageName=Str::slug($request->title).'.'.$request->image->getClientOriginalExtension();//uploadlanan resmin uzantısını tutar
            $request->image->move(public_path('uploads'),$imageName);
            $page->image = 'uploads/'.$imageName;
        }
        $page->save();
        toastr()->success('Başarılı', 'Sayfa Başarıyla Oluşturuldu');
        return redirect()->route('admin.page.index');
    }

    public function update($id) {
        $admin = Auth::user();
        $page = Page::findOrFail($id);
        return view('back.pages.update',compact('admin','page'));
    }

    public function updatePost(Request $request, $id) {
        $request->validate([
            'title'=>'min:3',
            'image' =>'image|mimes:jpeg,jpg,png|max:2048'
        ]);

        $page = Page::findOrFail($id);
        $page->title = $request->title;
        $page->content = $request->contentt;
        $page->slug = Str::slug($request->title);

        if ($request->hasFile('image')) {
            $imageName=Str::slug($request->title).'.'.$request->image->getClientOriginalExtension();//uploadlanan resmin uzantısını tutar
            $request->image->move(public_path('uploads'),$imageName);
            $page->image = 'uploads/'.$imageName;
        }
        $page->save();
        toastr()->success('Başarılı', 'Sayfa Başarıyla Güncellendi');
        return redirect()->route('admin.page.index');
    }

    public function delete($id) {
        $page = Page::find($id); //softdelete karşı tamamen silmek için
        if (File::exists($page->image)) {
            File::delete(public_path($page->image));
        }
        $page->delete();
        toastr()->success('Sayfa başarıyla silindi',"Başarılı");
        return redirect()->route('admin.page.index');
    }

    public function orders(Request $request) {
        foreach ($request->get('orders') as $key => $order) {
            Page::where('id',$order)->update(['order' => $key]);
        }
    }

}
