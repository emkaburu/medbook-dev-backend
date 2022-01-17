<?php


namespace App\Http\Utilities;


class StaticFunctions
{
    public static function checkContentType($request){
        // Check for Content-Type first
        if ($request->hasHeader('Content-Type')) {
            $content_type = $request->header('Content-Type');
            if(strcmp($content_type, 'application/json') == 0){
                $response = [
                    "Code" => 200
                ];
                return json_encode($response);

            }else{
                $response = [
                    "Code" => "403",
                    "Description" => "JSON data is required",
                ];
                return json_encode($response);
            }
        }else{
            $response = [
                "Code" => "403",
                "Description" => "The Content-Type Header is required",
            ];
            return json_encode($response);
        }
    }
}
