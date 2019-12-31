<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request; 
use Illuminate\Support\Carbon;
use Symfony\Component\HttpFoundation\File\UploadedFile;

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
        $response = null;
        if ($request->hasFile('jpg')) {
            $original_filename = $request->file('jpg')->getClientOriginalName();
            $original_filename_arr = explode('.', $original_filename);
            $file_ext = end($original_filename_arr);
            $destination_path = './upload/';
            $image = time() . '.' . $file_ext;
            if ($request->file('jpg')->move($destination_path, $image)) {
                $res = DB::table('trends')->insert([
                    'image_url' => '/upload/'.$image,
                    'kota' => $request->kota,
                    'fashion_item' => $request->fashion_item,
                    'accuracy' => $request->accuracy,
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now()
                ]);
        
                if ($res) {
                    return response()->json([
                        'msg' => 'success'
                    ]);
                } else {
                    return response()->json([
                        'msg' => 'error'
                    ]);
                }
            } else {
                return response()->json([
                    'msg' => 'cannot upload file'
                ]);
            }
        } else {
            return response()->json([
                'msg' => 'file not found'
            ]);
        }
    }

    public function getTrends(){
        $trends = DB::table('trends')->get();
        if (sizeof($trends) == 0){
            $trend = null;
        }
        
        return response()->json(['data' => $trends]);
    }

    public function getTrendById($id){
        $trend = DB::table('trends')->where('id',$id)->get();
        if (sizeof($trend) == 0){
            $trend = null;
        }
        return response()->json(['data' => $trend[0]]);
    }
}
