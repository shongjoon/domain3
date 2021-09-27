<?php

namespace App\Http\Controllers;

use App\CloudAccount;
use Illuminate\Http\Request;

class CloudAccountController extends Controller
{
    public function getAccounts(Request $request)
    {
        
        $account_list = CloudAccount::with('accountDomain')
            ->when($request->search, function ($query, $search) {
                return $query->where('site_name', 'like', '%' . $search . '%');
            })->when($request->select, function ($query, $select) {
                return $query->orderBy('updated_at', 'desc')->get();
            }, function ($query) {
                return $query->orderBy('updated_at', 'desc')->paginate(15);  
            });
        foreach ($account_list as $key => $value) {
            $account_list[$key]['count'] = count($value['accountDomain']);
        }
        return $account_list;
    }

    public function addAccount(Request $request)
    {
        $this->validate($request, [
            'account' => 'required',
            'api_key' => 'required',
            'site_name' => 'required',
        ]);
        CloudAccount::create([
            'account' => $request->account,
            'api_key' => $request->api_key,
            'site_name' => $request->site_name,
        ]);

    }
}
