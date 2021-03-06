
@extends('Frame.themes')

<!--<input type="text" id="country_name" name="tukhoa" class="form-control mr-md-1 semail" placeholder="Nhập từ khóa">-->
<style type="text/css">
  .dropdown-menu{
    width:350px;
  }
</style>


<div class="main-wrapper">

  <section class="cta-section theme-bg-light py-5" style="height: 200px; position: relative; ">
    <div class="container text-center" >

      <h2 class="heading">CHÀO MỪNG MỌI NGƯỜI ĐẾN VỚI BLOG TIN TỨC</h2>
      <div class="intro">Cập nhật tin tức mỗi ngày cho mọi người</div>
      <form class="signup-form form-inline justify-content-center pt-3" method ="GET" action ="{{url('timkiem')}}">
        <div class="form-group">          
         <div class="input-group">
          <div class="form-outline">
            <input type="search" autocomplete="off" id="country_name" class="form-control" name ="tukhoa" />
            <button type="submit" class="btn btn-primary">Tìm Kiếm</button>
            <div  id="countryList" style=""><br>
            </div>
            
          </div>
          {{ csrf_field() }}
        </div>
        
      </div>  

    </form>


  </div>
</section>

  @if (Session::has('message'))
    <div class="flash alert-info" style="text-align: center;">
      <p class="panel-body">
        <h3>{{ Session::get('message') }}</h3>
      </p>
    </div>
    @endif
    @if ($errors->any())
    <div class='flash alert-danger'>
      <ul class="panel-body">
        @foreach ( $errors->all() as $error )
        <li>
          {{ $error }}
        </li>
        @endforeach
      </ul>
    </div>
    @endif


@if( !$posts->count() )
Không có bài viết nào!!!

@else
@foreach( $posts as $post )

<div style="margin-top:30px;margin-bottom:30px;margin-left:100px; display: flex;width: 1000px;height: 230px; word-wrap: break-word;">
  <div style=" width:24%; height:100%; "><img src="{{ asset('uploads/' . $post->images) }}" style="height:225px;width:230px;"></div>
  <div style="width:78%;position:relative; padding: 10px; ">
    <div style="width:100%;font-size: 15pt;font-weight:bold;color: green "><h4><a href="{{ url('/'.$post->slug) }}">{{ $post->title }}</h4></a> </div>  
    <div style="width:100%; ">{{ $post->summary }}</div>
    <div style="margin-left:10px;position:absolute;bottom:0;left:0;  ">Người Đăng: <a href="{{ url('/user/'.$post->author_id)}}"> {{ $post->author->name }}</a>  --- Ngày Đăng: {{ $post->created_at->format('M d,Y \a\t h:i a') }}</div>
    <div style="position:absolute;bottom:0;right:0;  "><a href="{{ url('/'.$post->slug) }}"><button type="submit" class="btn btn-primary">Đọc Thêm</button></a>
      @if(!Auth::guest() && ($post->author_id == Auth::user()->id || Auth::user()->is_admin()))
      @if($post->active == '1')
      <button class="btn" style="float: right; border: 1px solid; background-color:; color:#F20B16; " ><a href="{{ url('edit/'.$post->slug)}}">Sửa Bài </a></button>

      @else
      <button class="btn" style="float: right; border: 1px solid; background-color:; color:#F20B16; " ><a href="{{ url('edit/'.$post->slug)}}">Sửa Bài </a></button>
      @endif
      @endif
    </div>
  </div>  
</div>
<hr>
@endforeach 



<div class ="container" style=" padding:30px;margin-left:500px;">


  <div class="text-xs-center">
    <ul class="pagination">
      <li>  {!! $posts->render() !!}</li> 
    </ul>
  </div>
</div>
@endif




<footer class="text-center text-white" style="background-color: #f1f1f1; ">

  <div class="container pt-4">

    <section class="mb-4">

      <a
      class="btn btn-link btn-floating btn-lg text-dark m-1"
      href="#!"
      role="button"
      data-mdb-ripple-color="dark"
      ><i class="fab fa-facebook-f"></i
        ></a>


        <a
        class="btn btn-link btn-floating btn-lg text-dark m-1"
        href="#!"
        role="button"
        data-mdb-ripple-color="dark"
        ><i class="fab fa-twitter"></i
          ></a>
          <a
          class="btn btn-link btn-floating btn-lg text-dark m-1"
          href="#!"
          role="button"
          data-mdb-ripple-color="dark"
          ><i class="fab fa-google"></i
            ></a>
            <a href="{{ url('/') }}"><i class="fas fa-home fa-fw mr-2" style=""></i></a>
            <a
            class="btn btn-link btn-floating btn-lg text-dark m-1"
            href="#!"
            role="button"
            data-mdb-ripple-color="dark"
            ><i class="fab fa-instagram"></i
              ></a>


              <a
              class="btn btn-link btn-floating btn-lg text-dark m-1"
              href="#!"
              role="button"
              data-mdb-ripple-color="dark"
              ><i class="fab fa-linkedin"></i
                ></a>

                <a
                class="btn btn-link btn-floating btn-lg text-dark m-1"
                href="#!"
                role="button"
                data-mdb-ripple-color="dark"
                ><i class="fab fa-github"></i
                  ></a>
                </section>

              </div>



              <div class="text-center text-dark p-3" style="background-color: rgba(0, 0, 0, 0.2);">

                © 2021 Công Nghệ Phầm Mềm:
                <a class="text-dark" href="">Hiếu Hùng Kiên</a>
              </div>
              <!-- Copyright -->
            </footer>


          </div>
          <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>

          <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
          <script>
            $(document).ready(function(){

   $('#country_name').keyup(function(){ //bắt sự kiện keyup khi người dùng gõ từ khóa tim kiếm
    var query = $(this).val(); //lấy gía trị ng dùng gõ
    if(query != '') //kiểm tra khác rỗng thì thực hiện đoạn lệnh bên dưới
    {
     var _token = $('input[name="_token"]').val(); // token để mã hóa dữ liệu
     $.ajax({
      url:"{{ route('search') }}", // đường dẫn khi gửi dữ liệu đi 'search' là tên route mình đặt bạn mở route lên xem là hiểu nó là cái j.
      method:"POST", // phương thức gửi dữ liệu.
      data:{query:query, _token:_token},
      success:function(data){ //dữ liệu nhận về
       $('#countryList').fadeIn();  
       $('#countryList').html(data); //nhận dữ liệu dạng html và gán vào cặp thẻ có id là countryList
     }
   });
   }else{
    $('#countryList').fadeIn(); 
    $('#countryList').html("");
  }
});

   $(document).on('click', 'li', function(){  
    $('#country_name').val($(this).text());  
    $('#countryList').fadeOut();  
  });  

 });
</script>

<!--
  <div class="item mb-5">
      <div class="media" > 
        <img src="{{ asset('uploads/' . $post->images) }}" style="height: 150px; width: 150px;"/>
        <div class="media-body" >
          <h3 class="title mb-1"><a href="{{ url('/'.$post->slug) }}">{{ $post->title }}</a></h3>
          <div class="meta mb-1"><span class="date">{{ $post->created_at->format('M d,Y \a\t h:i a') }}</span><span class="time"><a "href="{{ url('/user/'.$post->author_id)}}">{{ $post->author->name }}</a></span><span class="comment"><a href="#">  </a></span></div>
          <div class="intro">{{$post->summary}}</div>
          <a class="more-link" href="{{ url('/'.$post->slug) }}" style="font-size: 15px;">Đọc thêm</a>
        </div>
      </div>
    </div>
  -->
