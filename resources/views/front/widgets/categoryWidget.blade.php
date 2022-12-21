@isset($categories)
<div class="col-md-3">
    <div class="card">
        <div class="card-header">
            Kategoriler
        </div>
    </div>
    <div class="list-group">
        @foreach($categories as $category)
            <li class="list-group-item @if(Request::segment(2)==$category->slug) active @endif">
                <!--Request::segment url de ki her bir / örneğin /araba bir segmenttir biz burada 2. segmenti
                request kütüphanesi sayesinde yakalayarak category nin slug değerine eşit olup olmadığını
                kontrol ettik-->
                <a @if(Request::segment(2)!=$category->slug) href="{{route('category',$category->slug)}}" @endif >{{$category->name}}</a>
                <!--burasıda eğer kullanıcı zaten o kategorideyse linki olmasın-->
                <span class="badge bg-dark float-end ">{{$category->articleCount()}}<span/>
            </li>
        @endforeach
    </div>
</div>
@endisset
