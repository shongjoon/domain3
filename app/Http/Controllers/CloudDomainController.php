<?php

namespace App\Http\Controllers;

use App\CloudAccount;
use App\CloudDomain;
use Cloudflare\Api;
use Cloudflare\Zone;
use Illuminate\Http\Request;

class CloudDomainController extends Controller
{
    public function __construct()
    {
        $this->CloudDomain = new cloudDomain();

    }
    public function getDomain(Request $request)
    {
        return $this->CloudDomain->expireDomain($request->search);
    }

    public function getDomainList(Request $request)
    {

        if ($request->search) {

            $search = $request->search;
            // dump($search);
            // with 테이블의 쿼리 
            return $searchDomain = CloudDomain::whereHas('domainAccount', function ($query) use ($search) {
                $query->where('site_name', 'like', '%' . $search . '%');
                })
                ->with('domainAccount', 'getDns', 'site')
                ->orderBy('expire_date', 'desc')->paginate(15);
            // ->with(['domainAccount' => function ($query) use ($search) {
            //     $query->where('site_name', 'like', '%' . $search . '%');
            // }])
            // ->with('getDns', 'site')
            // ->orderBy('expire_date', 'desc')->paginate(15);

            // dump($test);
            // $test = CloudDomain::with('domainAccount:id,site_name')->where('site_name', 'like', '%' . $request->search . '%')
            // ->orderBy('expire_date', 'desc')->paginate(15);

            // return $test;
            // $test = CloudAccount::where('site_name', 'like', '%' . $request->search . '%')->get();
            // // dump(1);
            // // $domainList = CloudDomain::with('domainAccount','getDns')
            // //             ->when($request->search, function ($query, $search) {
            // // return $query->where('site_name', 'like', '%' . $search . '%');

            // // })->orderBy('expire_date', 'desc')->paginate(15);
            // foreach ($test as $key => $value) {
            //     // dump($value);
            //     $domainList[] =  CloudDomain::with('domainAccount', 'getDns')
            //     ->where('id', $value['id'])->orderBy('expire_date', 'desc')->paginate(15);
            // }
            // return $domainList;
        }
        if ($request->siteId) {
            return $siteDomain = CloudDomain::with('domainAccount')
                ->where('site', $request->siteId)
                ->with('getDns', 'site')
                ->orderBy('expire_date', 'desc')->paginate(15);
        }
        $domainList = CloudDomain::with('domainAccount', 'getDns', 'site')
            ->when($request->account_id, function ($query, $account_id) {
                return $query->where('account_id', $account_id);
            })
            ->orderBy('expire_date', 'desc')->paginate(15);
        return $domainList;
        // domainAccount
    }

    public function cloudAddDomain(Request $request)
    {
        $stmt = CloudAccount::where('account', $request->account)->first();
        $client = new Api($stmt['account'], $stmt['api_key']);
        $zone = new Zone($client);
        $creat_zone = $zone->create($request->name);
        // dump($creat_zone->errors[0]->message);
        if ($creat_zone->success) {
            return json_encode(array('success' => 'cloudflare zone 데이터를 생성하는데  성공했습니다. '));
        } elseif ($creat_zone->errors[0]->code == 1002) {
            return json_encode(array('error' => $creat_zone->errors[0]->message));
        } else {
            return json_encode(array('error' => 'cloudflare zone 데이터를 생성하는데  실패했습니다. '));
        }

    }
}
