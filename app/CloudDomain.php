<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use App\Http\Resources\DomainResource;

// use App\CloudAccount;
class CloudDomain extends Model
{
    public function expireDomain()
    {
        // $memo = Memo::orderBy('id', 'desc')->paginate(5);
        // return MemoResource::collection($memo);

        $dt = Carbon::now();
        $add15 = $dt->copy()->addDays(15)->format('Y-m-d H:i:s');
        $sub20 = $dt->copy()->subDay(30)->format('Y-m-d H:i:s');
        $get_domains = CloudDomain::with('site')->where([
            ['expire_date', '<', $add15],
            ['expire_date', '>', $sub20],
        ])->orderBy('expire_date', 'desc')->paginate(12);
        // dump(response()->json($get_domains) );
        // $test = CloudDomain::orderBy('id', 'desc')->paginate(10);
        // dump($get_domains->toArray());
        // dump($get_domains->toArray());
        return DomainResource::collection($get_domains);
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
}
