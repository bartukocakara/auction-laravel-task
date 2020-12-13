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
        $products = Product::where('ending_date' < Carbon::today());
        dd($products);
        return view('front.user-offers.index', ['products' => $products]);
    }

    public function userOfferPage($id)
    {
        $product = Product::findOrFail($id);
        $offers = $this->getGeneralData($product);
        $maxOffer = $this->getMaxPrice($id);
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
        $countFirstOffer = Offer::where('user_id', Auth::user()->id)->get();
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

            // Kullanıcı ürün için teklif yaptıktan sonra kullanıcı is_blocked yes yap
            $this->firstOfferCreate($request);
            $this->changeStatusAfterUsersOffer();

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
        else if($request->input('user_id') != $user->id and $request->input('amount') < $this->getMaxPrice($id))
        {
            $this->changeStatusAfterOtherUsersOffer($id);
        }
        else if($offer->is_blocked == 'NO')
        {
            Offer::create($createOffer);
            $this->changeStatusAfterUsersOffer($countFirstOffer);

        }

















        // // Ürünün başlangıç fiyatı tekliften düşükse ve daha önce teklif yapılmamışsa yeni teklif başlat
        // else if($product->starter_price < $request->input('amount') or $offer->is_blocked == 'NO')
        // {
        //     // Kullanıcının kredisinden ödediği miktar kadar düş
        //     $this->decreaseUsersCredit($user->credit, $request->input('amount'));


        //     // Kullanıcı ürün için teklif yaptıktan sonra kullanıcı is_blocked yes yap
        //     $countFirstOffer = Offer::where('user_id', Auth::user()->id)->get();
        //     $this->changeStatusAfterUsersOffer($countFirstOffer);

        //     // yeni teklif başlat
        //     $count = Offer::where('id', $id)->first();
        //     $this->firstOffer($count, $request);





        //     $offers = $this->getGeneralData($product);
        //     $createOffer = Offer::create($createOffer);
        //     $maxOffer = $this->getMaxPrice();
        //     return view('front.user-offers.offer-page', ['product' => $product,
        //                                                  'offers' => $offers,
        //                                                  'maxOffer' => $maxOffer,
        //                                                  'status' => 'Offer created successfully']);
        // }
        // // Eğer kullanıcınin o ürünle alakalı durumu blocked yes ise teklif vermesini engelle
        // else if($user->is_blocked == 'YES')
        // {
        //     return redirect()->back()->with(['status' => 'For offering price please wait for other offers']);

        // }

        // // Teklif verdiği ürün farklı ise ve teklifi kredisinin üstünde değilse teklifi varsay
        // // $getUsersLastOfferToProduct = Offer::where('product_id', $id)
        // else if($request->input('product_id') != $id)
        // {
        //     $createOffer = Offer::create($createOffer);
        // }

        // // Kullanıcının o ürüne teklif yapmasını engelle


    }
}
