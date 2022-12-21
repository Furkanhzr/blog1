<!-- Main Content-->
@extends('front.layouts.master')
@section('title','İletişim')
@section('bg','https://startbootstrap.github.io/startbootstrap-clean-blog/assets/img/contact-bg.jpg')
@section('content')
    <div class="col-md-10 col-lg-8 col-xl-7">
        @if(session('success'))
        <div class="alert alert-success">
            {{session('success')}}
        </div>
        @endif

            @if($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach($errors->all() as $error)
                            <li>{{$error}}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
        <p>Bizimle iletişime geçebilirsiniz.</p>
        <div class="my-5">
            <form method="post" action="{{route('contact.post')}}" >
                @csrf<!--formlarda gönderilir-->
                <div class="form-floating">
                    <input class="form-control" name="name" type="text" value="{{old('name')}}" placeholder="Ad Soyadınız" data-sb-validations="required" />
                    <label for="name">Ad-Soyad</label>              <!--old'un içine kalıbın name'i neyse onu yazıyoruz
                                                                    örneğin name="email" ise içine email-->
                                                                    <!--old'un özelliği ise örenğin name ise hatanın sebebi
                                                                       validation'dan name'in hatasını getiriyor???-->
                    <div class="invalid-feedback" data-sb-feedback="name:required">A name is required.</div>
                </div>

                <div class="form-floating">
                    <input class="form-control" name="email" type="email" value="{{old('email')}}" placeholder="Email Adresiniz" data-sb-validations="required,email" />
                    <label for="email">Email Adresi</label>
                    <div class="invalid-feedback" data-sb-feedback="email:required">An email is required.</div>
                    <div class="invalid-feedback" data-sb-feedback="email:email">Email is not valid.</div>
                </div>


                <div class="form-floating">
                    <select class="form-select"  name="topic" >
                        <option @if(old('topic')=="Bilgi") selected @endif >Bilgi</option>
                        <option @if(old('topic')=="Destek") selected @endif >Destek</option>
                        <option @if(old('topic')=="Genel") selected @endif >Genel</option>
                    </select>
                    <label >Konu</label>
                </div>


                <div class="form-floating">
                    <textarea class="form-control" name="message" placeholder="Mesajınız" style="height: 12rem">{{old('message')}}</textarea>
                    <label for="message">Mesaj</label>
                </div>
                <br />
                <!-- Submit success message-->
                <!---->
                <!-- This is what your users will see when the form-->
                <!-- has successfully submitted-->
                <div class="d-none" id="submitSuccessMessage">
                    <div class="text-center mb-3">
                        <div class="fw-bolder">Form submission successful!</div>
                        To activate this form, sign up at
                        <br />
                        <a href="https://startbootstrap.com/solution/contact-forms">https://startbootstrap.com/solution/contact-forms</a>
                    </div>
                </div>
                <!-- Submit error message-->
                <!---->
                <!-- This is what your users will see when there is-->
                <!-- an error submitting the form-->
                <div class="d-none" id="submitErrorMessage"><div class="text-center text-danger mb-3">Error sending message!</div></div>
                <!-- Submit Button-->
                <button class="btn btn-primary text-uppercase " name="submitButton" type="submit">Gönder</button>
            </form>
        </div>
    </div>

    <div class="col-md-3">
        <div class="card card-default">
            <div class="card-body">A Basic Panel</div>
            Adres: kşlk kşk qwqtq
        </div>
    </div>

@endsection


