<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\CloudDomain;
class CloudDomainController extends Controller
{
    public function __construct()
    {
        $this->CloudDomain = new cloudDomain();

    }
    public function getDomain() 
    {
        return $this->CloudDomain->expireDomain();
    }
}
