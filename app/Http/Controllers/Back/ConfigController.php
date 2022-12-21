<?php

namespace App\Http\Controllers\Back;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Config;
use Psy\Util\Str;

class ConfigController extends Controller
{
    public function index() {
        $admin = Auth::user();
        $config=Config::find(1);
        return view('back.config.index',compact('admin','config'));
    }

    public function update(Request $request) {
        $config = Config::find(1);
        $config->title = $request->title;
        $config->active = $request->active;
        $config->facebook = $request->facebook;
        $config->twitter = $request->twitter;
        $config->linkedin = $request->linkedin;
        $config->youtube = $request->youtube;
        $config->github = $request->github;
        $config->instagram = $request->instagram;

        if($request->hasFile('logo')) {
            $logo = Str::slug($request->slug).'-logo.'.$request->logo->getClientOriginalExtension();
            $request->logo->move(public_path('uploads',$logo));
            $config->logo='uploads/'.$logo;
        }

        if($request->hasFile('favicon')) {
            $logo = Str::slug($request->slug).'-favicon.'.$request->favicon->getClientOriginalExtension();
            $request->favicon->move(public_path('uploads',$favicon));
            $config->favicon='uploads/'.$favicon;
        }
        $config->save();
        toastr()->success('Ayarlar başarıyla güncellendi','Başarılı');
        return redirect()->back();
    }
}
