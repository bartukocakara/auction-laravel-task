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

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function firstOffer($count, Request $request)
    {
        if($count)
        {
            Offer::create($request->except('_token'))->first();
        }
    }

    public function changeStatusAfterUsersOffer($countUser)
    {
        if($countUser)
        {
            User::where('id', Auth::user()->id)->update(['is_blocked' => 'YES']);
        }
    }

    public function changeStatusAfterOtherUsersOffer($countOtherUser)
    {
        if($countOtherUser)
        {
            User::where('id', Auth::user()->id)->update(['is_blocked' => 'NO']);
        }
    }

    public function xxx($productId)
    {
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
