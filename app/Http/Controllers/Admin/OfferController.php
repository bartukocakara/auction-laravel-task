<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Offer;
use App\Models\Product;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class OfferController extends Controller
{
    public function userMain()
    {
        $products = Product::all();
        return view('front.user-offers.index', ['products' => $products]);
    }

    public function aboutToStart()
    {
        $products = Product::orderBy('starting_date', 'asc')->get();
        return view('front.about-to-start.index', ['products' => $products]);
    }

    public function userOfferPage($id)
    {
        // dd($this->getOffererBeforeLatest($id));
        $product = Product::findOrFail($id);
        $offers = $this->getGeneralData($product);
        $maxOffer = $this->getMaxPrice($id);
        $product = Product::where('id', $id)->first();
        // dd($maxOffer);
        if($product->ending_date < date('Y-m-d H:i:s'))
        {
            return redirect()->back();
        }
        return view('front.user-offers.offer-page', [
                                                        'product' => $product,
                                                        'maxOffer' => $maxOffer,
                                                        'offers' => $offers]);
    }

    public function userOfferSubmit(Request $request, $id)
    {
        // DATALAR
        $createOffer = $request->except('_token');
        $user = User::where('id', Auth::user()->id)->first();
        $product = Product::findOrFail($id);
        $offer = Offer::where(['product_id' => $id, 'user_id' => $user->id])->first();
        $offers = $this->getGeneralData($product);
        $maxOffer = $this->getMaxPrice($id);

        // Kredisinin üstünde teklif vermesini engelle
        if($user->user_credit < $request->input('amount') || $request->input('amount') < $product->starter_price)
        {
            return redirect()->back()->with(['status' => 'You don\'t have enough credit.']);
        }

        else if(!isset($offer))
        {
            //Kullanıcının teklifi kadar kredisinden düş
            $this->decreaseUsersCredit($user->user_credit, $request->input('amount'));
            // Başka kullanıcı ürün için teklif yaptıktan sonra bloke kaldır önceki teklif miktarı kadar geri ver
            $this->giveBackToUserAfterOtherUsersOffer($id);
            // Kullanıcı ürün için teklif yaptıktan sonra kullanıcı is_blocked yes yap diğerlerini no yap
            $this->firstOfferCreate($request);
            $this->changeStatusAfterOtherUsersOffer($id);
            // Diğer Kullanıcı teklif sunduktan sonra o kullanıcıdan bir öncekinin teklifi kadar kredi blokajını kaldır.Kredisini iade et

            $this->changeStatusAfterUsersOffer($id);
            return view('front.user-offers.offer-page', ['product' => $product,
                                                         'offers' => $offers,
                                                         'maxOffer' => $maxOffer,
                                                         'success' => 'Offer created successfully'
                                                         ]);
        }

        if($offer->is_blocked == 'YES')
        {
            return redirect()->back()->with(['status' => 'For offering price please wait for other offers.']);
        }
        else if($offer->is_blocked == 'NO')
        {
            if($product->ending_date < date('Y-m-d H:i:s'))
            {
                return redirect()->back()->with(['status' => 'You can\'t offer new price.Because deadline is over']);

            }
            $this->giveBackToUserAfterOtherUsersOffer($id);
            $this->decreaseUsersCredit($user->user_credit, $request->input('amount'));
            Offer::create($createOffer);
            $this->changeStatusAfterOtherUsersOffer($product->id);
            $this->changeStatusAfterUsersOffer($product->id);
            return view('front.user-offers.offer-page', ['product' => $product,
                                                         'offers' => $offers,
                                                         'maxOffer' => $maxOffer,
                                                         'success' => 'Offer created successfully'
                                                         ]);
        }
    }
}
