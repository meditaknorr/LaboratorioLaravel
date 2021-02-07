<?php

//namespace App\Http\Controllers\Api\Web;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Http\Request;

class CookiesController extends Controller
{

    /**
     * Create a Simple Cookie.
     *
     * @param       \Illuminate\Http\Request  $request
     * @return      null
     * @important   name, token, expires
     */
    public function cCreator(Request $request)
    {
        $name = $request->name;
        $value = $request->value;
        $expires = time() + (86400 * ($request->expires));
        $path = "/api/cookies/";
        $domain = "";
        $secure = false;
        $httponly = false;

        setrawcookie($name, $value, $expires, $path, $domain, $secure, $httponly);
    }

    /**
     * Create a JWT Cookie.
     *
     * @param       \Illuminate\Http\Request  $request
     * @return      null
     * @important   name, token, expires
     */
    public function cJWT(Request $request)
    {
        $name = $request->name;
        $token = $request->token;
        $expires = time() + (86400 * ($request->expires));
        $path = "/api/cookies/";
        $domain = "";
        $secure = false;
        $httponly = true;

        setrawcookie($name, $token, $expires, $path, $domain, $secure, $httponly);

    }

    /**
     * Retreive a Cookie value.
     *
     * @param   string $name
     * @return  \Illuminate\Http\JsonResponse
     */
    public function cRetrieval(string $name)
    {
        $value = Cookie::get($name);
        if (is_null($value)) {
            return response()->json(['response' => 'No Records!'], 404);
        }
        return response()->json($value, 200);
    }

    /**
     * Delete a Cookie.
     *
     * @param   string $name
     * @return  null
     */
    public function cRemoval(string $name)
    {
        //set the expiration date to 12 hour ago
        $expires = time() - 43200;
        $path = "/api/cookies/";
        $domain = "";
        $secure = false;
        $httponly = true;

        setrawcookie($name, "", $expires, $path, $domain, $secure, $httponly);
    }

    /**
     * Retreive a specific value from a existing Cookie.
     *
     * @param   string $name
     * @return  \Illuminate\Http\JsonResponse
     */
    public function cExists(string $name)
    {
        return Cookie::has($name) ? response()->json(['response' => 'false'], 404) : response()->json(['response' => 'true'], 200);
    }

}
