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

    public function getGeneralData($product)
    {
        return  Offer::where('product_id', $product->id)
                ->join('products', 'products.id', '=', 'offers.product_id')
                ->join('users', 'users.id', '=', 'offers.user_id')
                ->select('users.name as userName', 'offers.*', 'products.*')
                ->orderBy('amount', 'DESC')
                ->get();
    }

    public function getMaxPrice($productId)
    {
        return  Offer::where('product_id', $productId)->max('amount');
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

        return Offer::where([['user_id', '!=', Auth::user()->id,], ['product_id', '=', $id ]])
                            ->join('users', 'users.id', '=', 'offers.user_id')
                            ->select('users.*', 'offers.*')
                            ->update(
                                    [
                                        'user_credit' => $this->getMaxPrice($id)
                                    ]);
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
