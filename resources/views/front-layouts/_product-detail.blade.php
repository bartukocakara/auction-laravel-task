<div class="main-product">
    <div class="container">
       <div class="row">
          <div class="col-md-12">
             <div class="prod-page-title">
                <h1 style="color:white">All setup Sofa</h1>
                <p>By <span>Dex Morgan Mobilya</span></p>
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
                            <div class="tab-pane active" id="pic-1"><img src="{{ asset('front-assets/images/lag-60.png') }}" alt="#"></div>
                            <div class="tab-pane" id="pic-2"><img src="{{ asset('front-assets/images/lag-61.png') }}" alt="#"></div>
                            <div class="tab-pane" id="pic-3"><img src="{{ asset('front-assets/images/lag-60.png') }}" alt="#"></div>
                            <div class="tab-pane" id="pic-4"><img src="{{ asset('front-assets/images/lag-61.png') }}" alt="#"></div>
                         </div>
                      </div>
                   </div>
                </div>
             </div>
          </div>
          <div class="col-md-3 col-sm-12">
             <div class="price-box-right">
                <h4>Price</h4>
                <h3>1.320 ₺</h3>
                <p>Your Offer : </p>
                <form action="{{ route('user.offer') }}" method="post">
                    @csrf
                    <input type="number" class="form-control" name="offer" placeholder="00,00₺">
                    <br>
                    <button type="submit" class="btn btn-info p-10">Offer Price</button>
                </form>
                <h5><i class="fa fa-clock-o" aria-hidden="true"></i> <strong>16 hours</strong>passed after last offer</h5>
             </div>
          </div>
       </div>
    </div>
 </div>
