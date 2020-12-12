<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Offer;
use App\Models\Product;
use App\Models\User;
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

    public function userOfferPage($id)
    {
        $product = Product::findOrFail($id);
        $offers = DB::table('offers')
                ->where('product_id', $product->id)
                ->join('products', 'products.id', '=', 'offers.product_id')
                ->join('users', 'users.id', '=', 'offers.user_id')
                ->select('users.*', 'offers.*', 'products.*')
                ->orderBy('last_offer_time', 'DESC')
                ->get();
        $user = User::where('id', Auth::user()->id)->get();
        return view('front.user-offers.offer-page', ['product' => $product, 'offers' => $offers]);
    }

    public function userOfferSubmit(Request $request, $id)
    {
        $createOffer = $request->except('_token');
        $user = User::where('id', Auth::user()->id)->get();
        // Farklı ürün için teklif sunuyorsa kredisinin üstünde teklif vermesini engelle
        $product = Product::findOrFail($id);

        if($user->user_credit < $request->input('amount'))
        {
            return redirect()->back()->with(['status' => 'You don\'t have enough credit.']);
        }


        // Ürünün başlangıç fiyatı tekliften düşükse ve daha önce teklif yapılmamışsa yeni teklif başlat
        if($product->starter_price < $request->input('amount'))
        {
            $count = Offer::where('id', $id)->first();
            $this->firstOffer($count, $request);
            // O ürün için yapılan başka tekliften sonra kullanıcı is_blocked no yap
            $countOtherOffer = Offer::where('user_id', Auth::user()->id)->get();
            $this->changeStatusAfterOtherUsersOffer($countOtherOffer);
        }

        $offers = Offer::where('product_id', $product->id)->get();

        if($request->input('product_id') != $offers->product_id and $user->credit)
        {
            $createOffer = Offer::create($createOffer);
        }

        // Kullanıcının o ürüne teklif yapmasını engelle
        if($user->is_blocked == 'YES')
        {
            return redirect()->back()->with(['status' => 'For offering price please wait for other offers']);

        }
        else if($user->credit < $product->starter_price)
        {
            return redirect()->back()->with(['status' => 'You must offer more than starter price']);
        }

        $createOffer = Offer::create($createOffer);
        return view('front.user-offers.offer-page', ['product' => $product, 'offers' => $offers]);


    }
}
