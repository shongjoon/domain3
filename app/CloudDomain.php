<?php

namespace App;

use App\CloudSite;
use App\Http\Resources\DomainResource;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

// use App\CloudAccount;
class CloudDomain extends Model
{
    public function expireDomain($value)
    {
        // $memo = Memo::orderBy('id', 'desc')->paginate(5);
        // return MemoResource::collection($memo);
        // $value = '폭스';
        $siteId = '';
        if ($value) {
            $siteId = CloudSite::where('description', 'like', '%'.$value.'%')->first();
            $siteId = $siteId->id;
        }
        // dump('1',$siteId);
        $dt = Carbon::now();
        $add15 = $dt->copy()->addDays(15)->format('Y-m-d H:i:s');
        $sub20 = $dt->copy()->subDay(30)->format('Y-m-d H:i:s');
        // dump($add15);
        // $test = CloudDomain::with('site')->when($value, function($query, $value) {
        //     return $query->where('site', $siteId->id);
        // }, function ($query) {
        //     return $query->where([
        //     ['expire_date', '<', $add15],
        //     ['expire_date', '>', $sub20]
        //     ]})
        // ->orderBy('expire_date', 'desc')->paginate(10);
        // $test = CloudDomain::with('site')->where([
        //     ['expire_date', '<', $add15],
        //     ['expire_date', '>', $sub20]
        // ])
        // ->orderBy('expire_date', 'desc')->paginate(10);
        // $test = CloudDomain::with('site')->when($siteId->id, function ($query, $siteId) {
        //     dump('2', $siteId);
        //     return $query->where('site', $siteId);

        // }, function ($query) {
        //     dump(3);
        //     return $query->where([
        //         ['expire_date', '<', $this->add15],
        //         ['expire_date', '>', $this->sub20],
        //     ]);
        // })->orderBy('expire_date', 'desc')->paginate(10);
        $test = CloudDomain::with('site')->when($siteId, function ($query, $siteId) {
            // dump('2', $siteId);
            return $query->where('site', $siteId);

        })->where([
            ['expire_date', '<', $add15],
            ['expire_date', '>', $sub20]
        ])->orderBy('expire_date', 'desc')->paginate(13);

        // if($value) {

        //     $test1 = $test->filter(function($value, $key) {
        //         dump($value->name);
        //         return $value->site == $siteId;
        //     });
        // }
        // dump($test);
        // $check = $test->where('description', '다저스')->paginate(10);
        // $test1 = $test->where('site.description',$value);
        // $get_domains = CloudDomain::with('site')->where([
        //     ['expire_date', '<', $add15],
        //     ['expire_date', '>', $sub20],
        // ])->when($value, function ($query, $value) {
        //     return $query->where('cloud_sites.description', $value);
        // })
        // ->orderBy('expire_date', 'desc')->paginate(12);
        // dump(response()->json($get_domains) );
        // $test = CloudDomain::orderBy('id', 'desc')->paginate(10);
        // dump($get_domains->toArray());
        // dump($get_domains->toArray());
        return DomainResource::collection($test);
        // $test = CloudDomain::all();
        // dump($test1);
        // dump($test);
        // foreach ($domains as $key => $value) {
        //     $site = CloudSite::find($value['cloud_site_id']);
        //     $domains[$key]['site'] = $site['description'];
        // }
        // return $domains;
    }

    public function site()
    {
        return $this->belongsTo('App\CloudSite', 'site');
    }

    public function domainAccount()
    {
        return $this->belongsTo(CloudAccount::class, 'account_id');
    }

    public function getDns()
    {
        return $this->hasMany(CloudDns::class, 'domain_id');
    }
    
}
