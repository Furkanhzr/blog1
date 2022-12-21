<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Illuminate\Notifications\Messages\MailMessage;
//Models
use App\Models\Category;
use App\Models\Article;
use App\Models\Page;
use App\Models\Contact;
use App\Models\Config;

class HomePage extends Controller
{
    public function __construct() { //construct tüm fonksiyonlarda çalışmasını sağlayan bir fonksiyon.Kod tekrarından kurtulmamıza yarar.
        if (Config::find(1)->active==0) {
            return redirect()->to()
        }
        view()->share('pages',Page::orderBy('order','ASC')->get());
        view()->share('categories',Category::inRandomOrder()->get());
        //birinci kısma paylaşmak istediğimiz değişkenin adını ikinci kısm ise değikeni yazyıoruz.
    }

    public function index() {
        $articles=Article::orderBy('created_at','DESC')->paginate(2);//get yerine paginate yazarak sayfalandırma işlemi yapıyoruz.
        $articles->withPath(url('sayfa'));//paginate(sayfalama) işlemi için özel url belirleyebiliyoruz fakat bunun routesini belirtmemiz gerek.

        //$categories=Category::inRandomOrder()->get();Construct sayesinde yazmamıza gerek yok
        //$pages=Page::orderBy('order','ASC')->get();Construct sayesinde yazmamıza gerek yok
        return view('front.homepage',compact('articles'));
    }

    public function single($category,$slug) {
        $category=Category::whereSlug($category)->first() ?? abort(403,'Böylse bir sayfa bulunamadı');
        $article=Article::where('slug',$slug)->where('category_id',$category->id)->first() ?? abort(403,'Böylse bir sayfa bulunamadı');
                                               //buradaki sorguda eğer url yi kendi kategorisinden başka kategori yazılırsa
                                               //hata bastırmak için

        $article->increment('hit');//bir artttırmaya yarar sayfa görüntülenme sayısı için kullandık.
        //$categories=Category::inRandomOrder()->get();Construct sayesinde yazmamıza gerek yok
        return view('front.single',compact('article'));
    }

    public function category($slug) {
        $category=Category::whereSlug($slug)->first() ?? abort(403,'Böylse bir sayfa bulunamadı');
        $articles=Article::where('category_id',$category->id)->orderBy('created_at','DESC')->paginate(1);
        //$categories=Category::inRandomOrder()->get();Construct sayesinde yazmamıza gerek yok
        return view('front.category',compact('category','articles'));
    }

    public function page($slug) {
        $page=Page::whereSlug($slug)->first() ?? abort(403,'Böylse bir sayfa bulunamadı');
        //$pages=Page::orderBy('order','ASC')->get();Construct sayesinde yazmamıza gerek yok
        return view('front.page',compact('page'));
    }

    public function contact() {

        return view('front.contact');
}

    public function contactpost(Request $request) {

        $rules=[
            'name'=>'required | min:5',
            'email'=> 'required | email',
            'topic'=>'required',
            'message'=>'required | min:10',
        ];

        $validate=Validator::make($request->post(),$rules);

        if($validate->fails()) {
            return redirect()->route('contact')->withErrors($validate)->withInput() ;
        }

       // Mail::raw(' Mesajı Gönderen :'.$request->name. '<br/>
                        // Mesajı Gönderen Mail :'.$request->email.'<br/>
                         //Mesaj Konusu : '.$request->topic.' <br/>
                        // Mesaj : '.$request->message.' <br/> <br/>
                        // Mesaj Gönderilme Tarihi : '.now().' ', function ($message) use($request) {
            //$message->from('iletisim@blogsitesi.com','Blog Sitesi');
            //$message->to('frknhzr23@gmail.com');
            //$message->subject($request->name .' iletişimden mesaj gönderdi!');
       // });

        $contact=new Contact;
        $contact->name=$request->name;
        $contact->email=$request->email;
        $contact->topic=$request->topic;
        $contact->message=$request->message;
        $contact->save();
        return redirect()->route('contact')->with('success','İletisim mesajınız bize iletildi. Teşekkür ederiz.');
    }

}
