<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CloudSite extends Model
{
    protected $fillable = ['id', 'name', 'description'];

    public function domains()
    {
        return $this->hasMany('App\cloudDomain');
    }

    public function siteAccount()
    {
        return $this->hasMany(CloudAccount::class);
    }
}
