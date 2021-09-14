<?php

namespace App\Http\Controllers;

use App\Http\Resources\MemoResource;
use App\Memo;
use Illuminate\Http\Request;

class MemoController extends Controller
{
    public function getMemo(Request $request)
    {
        $memo = Memo::orderBy('id', 'desc')->paginate(5);
        return MemoResource::collection($memo);
    }

    public function createMemo(Request $request)
    {
        $this->validate($request, [
            'memo' => 'required',
        ]);
        return Memo::create([
            'memo' => $request->memo,
        ]);

    }

    public function deleteMemo(Request $request)
    {
        return Memo::where('id', $request->id)->delete();
    }
}
