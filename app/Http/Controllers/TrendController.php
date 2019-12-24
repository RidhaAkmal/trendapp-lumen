<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request; 
use Illuminate\Support\Carbon;

class TrendController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    public function insert(Request $request)
    {
        $res = DB::table('trends')->insert([
            'fashion_item' => $request->fashion_item,
            'image_url' => $request->image_url,
            'kota' => $request->kota,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
        ]);

        if ($res) {
            return response()->json($res);
        } else {
            return response()->json([
                'msg' => 'error',
                'code' => $request->status()
            ]);
        }
    }

    //
}
