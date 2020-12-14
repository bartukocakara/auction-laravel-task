<div class="main-product">
    <div class="container">
       <div class="row clearfix">
        @if (Auth::check())
        @foreach ($products as $product)
        <div class="col-lg-3 col-sm-6 col-md-3">
               <div class="box-img">
                    <h4>{{ $product->name }}</h4>
                    <img src="{{ asset('images/'.$product->image) }}" alt="">
                    @if ($product->ending_date < date('Y-m-d H:i:s'))
                        <p class="btn btn-danger">
                            Offering Ended.
                            Winner is :
                        </p>
                    @else
                    <a class="btn btn-info" href="{{ URL::to('user-offer-page/' . $product->id) }}">
                        Offer Price
                    </a>
                    <a class="btn btn-warning">
                        {{ $product->starting_date }}
                    </a>
                    @endif
               </div>
         </div>
        @endforeach
        @endif
       </div>
    </div>
 </div>
