<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class ProductsEdit
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        $error = false;
        $valid = false;
        $valid1 = false;
        $le = $request->route('id');
        if(!$request->hasHeader('X_ITE_TOKEN')){
            $error = true;
        }
        $token = $request->header('X_ITE-TOKEN');
        try{
            $jsonStr= base64_decode($token);
            $jsonPayLoad = json_decode($jsonStr , true);
            $file = file_get_contents('D:\user.json');
            $decode_file = json_decode($file , true);
            $file1 = file_get_contents('D:\data.json');
            $decode_file1 = json_decode($file1 , true);

            if(!$jsonPayLoad){
                $error = true;
            }
            if(!isset($jsonPayLoad['email'])){
                $error = true;
            }
            for($i =0 ; $i<count($decode_file) ; $i++){
                if($decode_file[$i]['email'] == $jsonPayLoad['email'] && $decode_file[$i]['password'] == $jsonPayLoad['password']){
                    $valid = true;
                }
            }
            if($decode_file['email'] == $decode_file[$le]['email']){
                $valid = true;
            }
        }catch(\Exception $exception){
            if($error) {
                return response()->json(['message' => 'Invalid TOKEN']);
            }
            if(!$valid && !$valid1){
                return response()->json(['message' => 'Incorrect Account']);
            }
        }
        return $next($request);
    }
}
