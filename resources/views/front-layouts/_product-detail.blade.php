
<div class="main-product">
    <div class="container">
       <div class="row">
        @if(Auth::check())

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
                            <div class="tab-pane active">
                                <img src="{{ asset('images/'.$product->image) }}" alt="#" width="400">
                            </div>
                      </div>
                   </div>
                </div>
                <div class="description-box">
                    <div class="dex-a">
                       <h3 style="color:red;border-bottom:1px solid red">Rules!</h3>
                       <p>You can only increase the offer and wait for other users before yoo offer new one
                       </p>
                    </div>
                    <div class="spe-a">
                       <h3 style="color:blue; border-bottom:1px solid black">OFFERS</h3>
                       <ul>
                            <li class="clearfix">
                                <div class="col-md-3">
                                    <p>User Name</p>
                                </div>
                                <div class="col-md-3">
                                    <p>Offer Amount</p>
                                </div>
                                    <div class="col-md-3">
                                    <p>Last Offer Time</p>
                                </div>
                                <div class="col-md-3">
                                    <p>User Blocked YES/NO</p>
                                </div>
                            </li>
                            <hr>
                           @foreach ($offers as $offer)
                           <li class="clearfix">
                            <div class="col-md-3">
                               <h5>{{ $offer->users->name }}</h5>
                            </div>
                            <div class="col-md-3">
                               <p>{{ $offer->amount }}</p>
                            </div>
                            <div class="col-md-3">
                                <p>{{ $offer->last_offer_time }}</p>
                            </div>
                            <div class="col-md-3">
                                <p>{{ $offer->is_blocked }}</p>
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
                 <div class="d-flex">
                     <div>
                <h4>Last Price</h4>
                @if (isset($maxOffer))
                        <h3>{{ $maxOffer }}</h3>
                @else
                        <h3>{{ $product->starter_price }} ₺</h3>
                @endif
            </div>
                </div>
                <p>Your Offer : </p>
                <form action="{{ URL::to('user-offer-page/' . $product->id) }}" method="post">
                    @csrf
                    <input type="hidden" class="form-control" name="product_id" value="{{ $product->id }}">
                    <input type="hidden" class="form-control" name="user_id" value="{{ Auth::user()->id }}">
                    <input type="number" class="form-control" name="amount" placeholder="00,00₺" required>
                    <input type="hidden" class="form-control" name="is_blocked" value="YES" placeholder="00,00₺" required>
                    <br>
                    @if(session('status'))
                    <div class="alert alert-warning" role="alert">
                        {{ session('status')}}
                    </div>
                    @endif

                    <button type="submit" class="btn btn-info p-10">Offer Price</button>
                </form>
                <h5><i class="fa fa-clock-o" aria-hidden="true"></i> <strong>16 hours</strong>passed after last offer</h5>
             </div>
          </div>
       </div>
       @else
       <div class="col-md-12">
        <div class="prod-page-title">
           <h1 style="color:white">For joining offers please create account or login</h1>
        </div>
     </div>
       @endif
    </div>
 </div>
