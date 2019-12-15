<?php

namespace Bertvthul\Simplexhr;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class SimplexhrController extends Controller
{
    public function call(Request $request)
    {
        if ($request->input('call') && strpos($request->input('call'), '.') !== false) {
        	$call = explode('.', $request->input('call'));
        	$controllerName = $call[0];
            if (strpos($controllerName, 'Controller') !== false) {
                $controllerName = str_replace('Controller', '', $controllerName);
            }
        	$functionName = $call[1];
            try {
               $controller = app()->make('\App\Http\Controllers\\' . $controllerName . 'Controller');
    	       return $controller->$functionName($request);
           } catch (\Exception $e) {
                return response()->json([
                    'success'   => false, 
                    'msg'       => $e->getMessage(),
                ]);
            }
        }
   
        return response()->json([
            'success'   => false,
            'msg'       => 'Provide a controller and function like "Product.addToCart"', 
            'post'      => $request->all(),
        ]);
    }
}
