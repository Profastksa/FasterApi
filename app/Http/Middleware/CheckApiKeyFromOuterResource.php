<?php

namespace App\Http\Middleware;

use App\Models\ClientsTokens;
use Closure;
use Illuminate\Http\Request;

class CheckApiKeyFromOuterResource
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        // if(getallheaders()['api_key'])
        //     $key = getallheaders()['api_key'];

        if ( getallheaders()['api_key'] && ClientsTokens::where('api_key', '=', getallheaders()['api_key'])->count() > 0) {
            // dd($key);
            return $next($request);
         }else{
             return response()->json([
                 'status'=> false,
                 'messages' => 'some thing wentwromg',
             ]);
         }

    }
}
