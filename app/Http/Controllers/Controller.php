<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

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
