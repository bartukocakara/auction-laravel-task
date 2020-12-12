<div class="main-product">
    <div class="container">
       <div class="row clearfix">

        @foreach ($products as $product)
        <div class="col-lg-3 col-sm-6 col-md-3">
            <a href="productpage.html">
               <div class="box-img">
                    <h4>{{ $product->name }}</h4>
                    <img src="{{ asset('images/'.$product->image) }}" alt="">
                    <a class="btn btn-info" href="{{ URL::to('user-offer-page/' . $product->id) }}">Offer Price</a>
               </div>
            </a>
         </div>
        @endforeach

       </div>
    </div>
 </div>
