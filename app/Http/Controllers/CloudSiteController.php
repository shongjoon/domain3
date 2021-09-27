<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\CloudSite;

class CloudSiteController extends Controller
{
    public function getSite()
    {
        return CloudSite::orderBy('id', 'desc')->paginate(15);

    }

    public function addSite(Request $request)
    {
        dump($request);
        $this->validate($request, [
            'name' => 'required',
            'description' => 'required',
        ]);
        CloudSite::create([
            'name' => $request->name,
            'description' => $request->description,
        ]);
    }
}
