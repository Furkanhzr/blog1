@if(count($articles)>0)
@foreach($articles as $article)
    <!-- Post preview-->
    <div class="post-preview">
        <a href="{{route('single',[$article->getCategory->slug,$article->slug])}}">
            <h2 class="post-title">{{$article->title}}</h2>
            <img src="{{asset($article->image)}}" alt="" width="700" height="350" style="display:flex">
            <h3 class="post-subtitle">{!!Str::limit($article->content,75)!!}</h3><!--Str::limit içine aldığı yazının örenğin 55 harfini gösterir-->
        </a>
        <p class="post-meta">Kategori:
            <a href="#!">{{$article->getCategory->name}}</a>
            <span class="float-end">{{$article->created_at->diffForHumans()}}</span>
            <!--diffForHumans() ilgili girilmiş tarihin kaç saat önce kaç yıl önce olduğunu gösteremeye yarar created at upadated at için-->
        </p>
    </div>
    @if(!$loop->last)
        <hr class="my-4" />
    @endif
@endforeach
{{$articles->links('pagination::bootstrap-4')}} <!--pagination nun linkteki css hatası 'pagination::bootstrap-4' bunun ile çözüldü-->
@else
    <div class="alert alert-danger">
        <h1>Bu kategoriye ait yazı bulunamadı.</h1>
    </div>
@endif
