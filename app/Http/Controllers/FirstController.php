<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class FirstController extends Controller
{
    public function check(Request $request){
        return response()->json(['message' => 'Login Success']);
    }
    public function deleteByID($id){
        $file = file_get_contents('D:\data.json');
        $decode_file = json_decode($file , true);
        if($id <1 || $id > count($decode_file)){
            return response()->json(['message' => 'Invalid ID'] , 400);
        }
        unset($decode_file[$id - 1]);
        file_put_contents('D:\data.json' , json_encode(array_values($decode_file)));
        return response()->json(['message' => 'product has been deleted successfully']);
    }
}
