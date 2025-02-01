@extends('tamplate.app2')

@section('content')

<!-- Hero Section Begin -->
<section class="hero hero-normal">
  <div class="container">
      <div class="row">
          <div class="col-lg-3">
              <div class="hero__categories">
                  <div class="btn btn-secondary">Back</div>
              </div>
          </div>
          <div class="col-lg-9">
              <div class="hero__search">
                  <div class="hero__search__form">
                      {{-- <form action="#">
                          <div class="hero__search__categories">
                              All Categories
                              <span class="arrow_carrot-down"></span>
                          </div>
                          <input type="text" placeholder="What do yo u need?">
                          <button type="submit" class="site-btn">SEARCH</button>
                      </form> --}}
                  </div>
                  <div class="hero__search__phone">
                      <div class="hero__search__phone__icon">
                          <i class="fa fa-phone"></i>
                      </div>
                      <div class="hero__search__phone__text">
                          <h5>+65 11.188.888</h5>
                          <span>support 24/7 time</span>
                      </div>
                  </div>
              </div>
          </div>
      </div>
  </div>
</section>
<!-- Hero Section End -->

<!-- Breadcrumb Section Begin -->
{{-- <section class="breadcrumb-section set-bg" style="filter: brightness(50%),position: absolute,
          left: 0px,
          top: 0px,
          z-index: -1" 
  data-setbg="{{ Storage::url($data->user->image) }}">
  <div class="container" style="">
      <div class="row">
          <div class="col-lg-12 text-center">
              <div class="breadcrumb__text">
                  <h2>{{ $data->user->first_name }}</h2>
                  <div class="breadcrumb__option">
                      <a href="./index.html">Home</a>
                      <a href="./index.html">Vegetables</a>
                      <span>Vegetable’s Package</span>
                  </div>
              </div>
          </div>
      </div>
  </div>
</section> --}}
<!-- Breadcrumb Section End -->

<!-- Product Details Section Begin -->
<section class="product-details spad">
  <div class="container">
      <div class="row">
          <div class="col-lg-6 col-md-6">
              <div class="product__details__pic">
                  <div class="product__details__pic__item">
                      <img class="product__details__pic__item--large" style="object-fit: cover"
                          src="{{ Storage::url($data->user->image) }}" alt="">
                  </div>
              </div>
          </div>
          <div class="col-lg-6 col-md-6">
              <div class="product__details__text">
                  <h3>{{ $data->user->first_name }} {{ $data->user->last_name }}</h3>
                  
                  <div class="product__details__rating">
                    @for ($i = 1; $i <= 5; $i++)
                        @if ($i <= floor($avgStar))
                            <i class="fa fa-star"></i>
                        @elseif ($i - $avgStar < 1)
                            <i class="fa fa-star-half-o"></i>
                        @else
                            <i class="fa fa-star-o "></i>
                        @endif
                    @endfor
                        <span>({{$reviews->count()}} reviews)</span>
                  </div>
                  <div class="product__details__price">RP. {{ number_format($data->salary,0,',','.') }}</div>
                  <p><?php echo $data->description ?? ''; ?></p>
                  {{-- <div class="product__details__quantity">
                      <div class="quantity">
                          <div class="pro-qty">
                              <input type="text" value="1">
                          </div>
                      </div>
                  </div> --}}
                    @if (auth()->user() && auth()->user()->level_user == 2)
                        <form action="{{ route('place.order', $data->user) }}" method="POST" style="display: inline;">
                            @csrf
                            <button type="submit" class="primary-btn">Pesan Sekarang</button>
                        </form>
                    @elseif (auth()->user() && auth()->user()->level_user != 2)
                        <div></div>
                    @else
                        <a href="{{ route('login') }}" class="primary-btn">Login to Order</a>
                    @endif
              
                  {{-- <a href="#" class="heart-icon"><span class="icon_heart_alt"></span></a> --}}
                  <ul>
                      <li><b>Pendidikan</b> <span>{{ $data->education }}</span></li>
                      <li><b>Tinggi</b> <span>{{ $data->tall }} cm</span></li>
                      <li><b>Berat</b> <span>{{ $data->heavy }} kg</span></li>
                      <li><b>Skills</b> <span>{{ $data->skills }}</span></li>
                      <li><b>Suku Asal</b> <span>{{ $data->tribe_of_origin }}</span></li>
                  </ul>
              </div>
          </div>
          <div class="col-lg-12">
              <div class="product__details__tab">
                  <ul class="nav nav-tabs" role="tablist">
                      <li class="nav-item">
                          <a class="nav-link active" data-toggle="tab" href="#tabs-1" role="tab"
                              aria-selected="true">Description</a>
                      </li>
                      <li class="nav-item">
                          <a class="nav-link" data-toggle="tab" href="#tabs-2" role="tab"
                              aria-selected="false">Information</a>
                      </li>
                      <li class="nav-item">
                          <a class="nav-link" data-toggle="tab" href="#tabs-3" role="tab"
                              aria-selected="false">Reviews <span>({{$reviews->count()}})</span></a>
                      </li>
                  </ul>
                  <div class="tab-content">
                      <div class="tab-pane active" id="tabs-1" role="tabpanel">
                          <div class="product__details__tab__desc">
                              <h6>Products Infomation</h6>
                              <p><?php echo $data->description ?? ''; ?></p>
                          </div>
                      </div>
                      <div class="tab-pane" id="tabs-3" role="tabpanel">
                        @if ($reviews->isNotEmpty())
                            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4 product__details__text">
                                @foreach ($reviews as $review)
                                    <div class="bg-white shadow-sm rounded-xl p-4 my-2">
                                        <div class="flex items-center mb-2 product__details__rating">
                                            @for ($i = 1; $i <= 5; $i++)
                                                @if ($i <= floor($review->star))
                                                    <i class="fa fa-star"></i>
                                                @elseif ($i - $review->star < 1)
                                                    <i class="fa fa-star-half-o"></i>
                                                @else
                                                    <i class="fa fa-star-o "></i>
                                                @endif
                                            @endfor
                                        </div>
                                        <p class="text-sm my-2" style="font-weight: 600">{{ $review->user->first_name.' '.$review->user->last_name }}</p>
                                        <p class="text-sm my-2">Rating: {{ $review->star }}/5</p>
                                        <p class="text-lg mb-2">{{ $review->comment }}</p>
                                    </div>
                                @endforeach
                            </div>
                        @else 
                            <p>Belum ada review</p> 
                        @endif
                      </div>
                  </div>
              </div>
          </div>
      </div>
  </div>
</section>
<!-- Product Details Section End -->

<!-- Related Product Section Begin -->
<section class="related-product">
  <div class="container">
      <div class="row">
          <div class="col-lg-12">
              <div class="section-title related__product__title">
                  <h2>Pekerja</h2>
              </div>
          </div>
      </div>
      <div class="row">
        @foreach ($pekerja as $item)
            <div class="col-lg-3 col-md-4 col-sm-6 mix oranges fresh-meat">
                <div class="featured__item">
                    <div class="featured__item__pic set-bg" data-setbg="{{ Storage::url($item->user->image) }}">
                        <ul class="featured__item__pic__hover">
                            <li><a href="{{ route('pekerja.detail', $item->id) }}"><i class="fa fa-eye"></i></a></li>
                        </ul>
                    </div>
                    <div class="featured__item__text">
                        <h6><a href="#">{{ $item->user->first_name }} {{ $item->user->last_name }}</a></h6>
                        <h5>Rp. {{ number_format($item->salary, 0, ',', '.') }}</h5>
                    </div>
                </div>
            </div>
        @endforeach
      </div>
  </div>
</section>
<!-- Related Product Section End -->
@endsection
