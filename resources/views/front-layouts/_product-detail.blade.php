<div class="main-product">
    <div class="container">
       <div class="row">
          <div class="col-md-12">
             <div class="prod-page-title">
                <h1 style="color:white">{{ $product->name }}</h1>
             </div>
          </div>
       </div>
       <div class="row">
          <div class="col-md-2 col-sm-4">
             <div class="left-profile-box-m prod-page">
             </div>
          </div>
          <div class="col-md-7 col-sm-8">
             <div class="md-prod-page">
                <div class="md-prod-page-in">
                   <div class="page-preview">
                      <div class="preview">
                         <div class="preview-pic tab-content">
                            <div class="tab-pane active" id="pic-1"><img src="{{ asset('images/'.$product->image) }}" alt="#"></div>
                         </div>
                      </div>
                   </div>
                </div>
                <div class="description-box">
                    <div class="dex-a">
                       <h4>Rules</h4>
                       <p>You can only increase the offer or wait for other users
                       </p>
                    </div>
                    <div class="spe-a">
                       <h4>OFFERS</h4>
                       <ul>

                           @foreach ($offers as $offer)
                           <li class="clearfix">
                            <div class="col-md-4">
                               <h5>{{ $offer->name }}</h5>
                            </div>
                            <div class="col-md-4">
                               <p>{{ $offer->credit }}</p>
                            </div>
                            <div class="col-md-4">
                                <p>{{ $offer->last_offer_time }}</p>
                             </div>
                            </li>
                           @endforeach
                       </ul>
                    </div>
                 </div>
             </div>
          </div>
          <div class="col-md-3 col-sm-12">
             <div class="price-box-right">
                <h4>Price</h4>
                <h3>{{ $product->starter_price }} ₺</h3>
                <p>Your Offer : </p>
                <form action="{{ URL::to('user-offer-page/' . $product->id) }}" method="post">
                    @csrf
                    <input type="hidden" class="form-control" name="product_id" value="{{ $product->id }}">
                    <input type="hidden" class="form-control" name="user_id" value="{{ Auth::user()->id }}">
                    <input type="number" class="form-control" name="amount" placeholder="00,00₺" required>
                    <br>
                    <button type="submit" class="btn btn-info p-10">Offer Price</button>
                </form>
                <h5><i class="fa fa-clock-o" aria-hidden="true"></i> <strong>16 hours</strong>passed after last offer</h5>
             </div>
          </div>
       </div>
    </div>
 </div>
