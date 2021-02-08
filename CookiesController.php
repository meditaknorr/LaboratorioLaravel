<?php

//namespace App\Http\Controllers\Api\Web;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Http\Request;

class CookiesController extends Controller
{

    /**
     * Create a Encrypted Cookie.
     * By Default Laravel uses and works with Encrypted Cookies.
     *
     * @param       \Illuminate\Http\Request  $request
     * @return      null
     * @important   name, token, expires
     */
    public function Encrypted(Request $request)
    {
        $name = $request->name;
        $value = $request->value;
        $expires = time() + (86400 * ($request->expires));
        $path = "/api/cookies/";
        $domain = "";
        $secure = false;
        $httponly = true;

        setrawcookie($name, $value, $expires, $path, $domain, $secure, $httponly);
    }

    /**
     * Create a Unencrypted Cookie.
     *
     * @param       \Illuminate\Http\Request  $request
     * @return      null
     * @important   name, token, expires
     */
    public function Unencrypted(Request $request)
    {
        $name = $request->name;
        $token = $request->token;
        $expires = time() + (86400 * ($request->expires));
        $path = "/api/cookies/";
        $domain = "";
        $secure = false;
        $httponly = false;

        setrawcookie($name, $token, $expires, $path, $domain, $secure, $httponly);

    }

    /**
     * Retreive a Cookie value.
     *
     * @param   string $name
     * @return  \Illuminate\Http\JsonResponse
     */
    public function Retrieve(string $name)
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
    public function Remove(string $name)
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
    public function Check(string $name)
    {
        return Cookie::has($name) ? response()->json(['response' => 'false'], 404) : response()->json(['response' => 'true'], 200);
    }

}
