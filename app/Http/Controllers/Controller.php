<?php

namespace App\Http\Controllers;

use App\Models\Offer;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function firstOfferCreate(Request $request)
    {
        return Offer::create($request->except('_token'))->first();

    }

    public function changeStatusAfterUsersOffer($productId)
    {
        return Offer::where(['user_id' => Auth::user()->id, 'is_blocked' => 'NO', 'product_id' => $productId])->update(['is_blocked' => 'YES']);
    }


    public function changeStatusAfterOtherUsersOffer($productId)
    {
        return Offer::where(['is_blocked' => 'YES', 'product_id' => $productId])
                                ->update(['is_blocked' => 'NO']);
    }
    public function checkUsersStatusBeforeOffering($id, $status, $product, $createOffer, $user, $offers, $maxOffer, Request $request)
    {
        // Kredisinin üstünde teklif vermesini engelle
        if($user->user_credit < $request->input('amount') || $request->input('amount') < $product->starter_price || $request->input('amount') < $maxOffer)
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

        else if($status === 'YES')
        {
                return redirect()->back()->with(['status' => 'For offering price please wait for other offers.']);
        }
        else if($status == 'NO')
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

    public function getGeneralData($product)
    {
        return Offer::where('product_id', $product->id)->with('products', 'users')
        ->orderBy('amount', 'DESC')
        ->get();
    }

    public function getMaxPrice($productId)
    {
        return Offer::where('product_id', $productId)->max('amount');
    }

    public function getMaxPriceAfterOffer($productId)
    {
        $maxOffer =  Offer::where('product_id', $productId)->max('amount');

        if(isset($maxOffer))
        {
            return $maxOffer;
        }
        else
        {
            return 0;
        }
    }

    public function getMaxOfferRow($productId)
    {
        if($this->getMaxPriceAfterOffer($productId) != null)
        {
            return Offer::where(['amount' => $this->getMaxPrice($productId), 'product_id' => $productId])
                            ->join('users', 'users.id', '=', 'offers.user_id')
                            ->select('users.*', 'offers.*')
                            ->first();
        }
        else
        {
            return 0;
        }
    }

    public function getMaxOfferRows($productId)
    {
        if($this->getMaxPrice($productId))
        {
            return Offer::where(['amount' => $this->getMaxPrice($productId), 'product_id' => $productId])
                            ->join('users', 'users.id', '=', 'offers.user_id')
                            ->join('products', 'products.id', '=', 'offers.product_id')
                            ->select('users.*', 'offers.*')
                            ->get();
        }
        else
        {
            return 0;
        }
    }

    public function getOffererBeforeLatest($productId)
    {
        return Offer::where('product_id', $productId)->latest('last_offer_time')->first();
    }

    public function decreaseUsersCredit($credit ,$amount)
    {
        return User::where('id', Auth::user()->id)
                    ->update(
                            [
                                'user_credit' => $credit - $amount,
                            ]);
    }

    public function giveBackToUserAfterOtherUsersOffer($id)
    {
        if($this->getMaxOfferRow($id) == null)
        {
            return Offer::where(['amount' => $this->getMaxPrice($id), 'product_id' => $id])
            ->join('users', 'users.id', '=', 'offers.user_id')
            ->select('users.*', 'offers.*')
            ->update(
                    [
                        'user_credit' => 0 + $this->getMaxPriceAfterOffer($id)
                    ]);
        }
        else {
            return Offer::where(['amount' => $this->getMaxPrice($id), 'product_id' => $id])
            ->join('users', 'users.id', '=', 'offers.user_id')
            ->select('users.*', 'offers.*')
            ->update(
                    [
                        'user_credit' => $this->getMaxOfferRow($id)->user_credit + $this->getMaxPriceAfterOffer($id)
                    ]);
        }

    }


    public function createData($params, $data)
    {
        if($params)
        {
            return redirect()->back()->with('status', $data.' added successfully.');
        }
        else
        {
            return redirect()->back()->with('status', $data.' couldn\'t created.');
        }
    }

    public function updateData($params, $data)
    {
        if($params)
        {
            return redirect()->back()->withInput()->with('status', $data.' updated successfully.');
        }
        else
        {
            return redirect()->back()->withInput()->with('status', $data.' couldn\'t updated.');
        }
    }

    public function deleteData($deleteData, $model, $id, $modelName)
    {
        if($deleteData)
        {
            $model::where('id', '=', $id)->delete();
            return redirect()->back()->with('status', $modelName.' deleted successfully');
        }
        else
        {
            return redirect()->back()->with('status', $modelName.' couldn\'t deleted');

        }
    }
}
