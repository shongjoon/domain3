<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CloudAccount extends Model
{
    protected $fillable = ['account', 'api_key', 'site_name'];

    public function accountDomain()
    {
        return $this->hasMany(CloudDomain::class, 'account_id');
    }

    public function accountDns()
    {
        return $this->hasMany(CloudDns::class, 'account_id');
    }

    public function getAccount()
    {
        dump('CloudAccount getAccount');
    }
}
