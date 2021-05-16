<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
// use Illuminate\Routing\Controller as BaseController;
// use Auth;
use Illuminate\Support\Facades\Auth;
use JWTAuth;
use Tymon\JWTAuthExceptions\JWTException;
use App\Http\Middleware\AccessToken;


class AuthControllerEth extends Controller
{
  
 /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    // use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    // protected $redirectTo = '/';
    protected $JsonToken;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        // $this->middleware('auth', ['except' => ['/']]);
        // $this->middleware('guest')->except('logout');
    }


    public function user(Request $request)
    {	
	
        // Check validation
            // $this->validate($request, [
            //     'ethid' => 'required',     
            // ]);
        
        // echo $request->get('publicAddress');exit;
        $publicAddress = $request->json('publicAddress');
        $user = User::where('publicAddress', $publicAddress)->first();
        // var_dump($user);
        //  $user = new User;
        //  $user->publicAddress= $publicAddress;
        //  $user->nonce = rand(10000, 99999);
        //  $user->save();
        // if($user){
            return response()->json($user, 200);//
        // }
    }



/*
        try {
                // verify the credentials and create a token for the user
                if (! $token = JWTAuth::fromUser($user)) {
                    return response()->json(['error' => 'invalid_credentials'], 401);
                }
            } catch (JWTException $e) {
                // something went wrong
                return response()->json(['error' => 'could_not_create_token'], 500);
            }


            // if no errors are encountered we can return a JWT
            $token = JWTAuth::fromUser($user);
        
        $name = "token";
        $value = $token;
        $expire = time() + 60;
        setcookie($name, $value, $expire,  "/");
        
        // Set Auth Details
            \Auth::login($user);
        

        
        // Redirect home page
        return redirect()->route('welcome');
        

*/


   public function signup(Request $request)
    {
        $user = new User;
        $user->publicAddress= $request->get('publicAddress');
        $user->nonce = rand(10000, 99999);
        // add more fields (all fields that users table contains without id)
        $user->save();
        return response()->json($user, 200);
    }

    public function metaAuth(Request $request)
    {
        //sign
        $user = User::where('publicAddress', $request->get('publicAddress'))->first();
        if(!$user) {
            return response()->json(['error' => 'user not found'], 403);
        };
        // try {
        //     // verify the credentials and create a token for the user
        //     if (! $token = JWTAuth::fromUser($user)) {
        //         return response()->json(['error' => 'invalid_credentials'], 401);
        //     }
        // } catch (JWTException $e) {
        //     // something went wrong
        //     return response()->json(['error' => 'could_not_create_token'], 501);
        // }


	    // if no errors are encountered we can return a JWT
        // $myTTL = 1200;
        // JWTAuth::factory()->setTTL($myTTL);
        $token = JWTAuth::fromUser($user);
        // $token = auth()->attempt($user);
        // auth()->login($user);
        $name = "token";
        $value = $token;
        // header("token: '''");
        // header("location: /dsfas/as");
        // JWTAuth::attempt($user);
        // $expire = time() + 6000;
        // setcookie($name, $value, $expire,  "/");
        
        
        session([$name => $value]);
        
        // Set Auth Details
        // $token = \Auth::attempt($user);
	

	
       // Redirect home page
    //    return redirect()->route('artworks');
        // sleep(2);
       return response()->json(['token' => $token], 200);
    }


   public function showLoginForm()
    {
        // if(session_is_registered('token')){
            // return redirect()->route('artworks');
        // }
        return view('auth.ethlogin');
        
        
    }

    public function artworks_confirm(Request $request, Response $response) {
        // return redirect('artworks', 302, ['Authorization'=>$request->get('token')]);
        // header("Authorization: ".$request->get('token'));
        // header("Location: /artworks/");
        // var_dump($request->headers);
        $request->headers->set('Authorization', $request->get('token'));
        $response->headers->set('Authorization', $request->get('token'));
        
        return \redirect('artworks_confirm_get', 302, ['Authorization'=>$request->get('token')]);
        // return \redirect()->route('artworks_confirm_get', [], 302, ['Authorization'=>'Bearer '.$request->get('token')]);
        // return response()->json(['res'=>$request->get('token')]);
        // var_dump($request->headers); exit();
        // return view('artworks_confirm');
        // header("Header2: ....");
        // return redirect('artworks_confirm_get', 302, [
        //     'Authorization' => $request->get('token')
        // ]);
            // return redirect()->route('artworks', [], 302, ['Authorization' => session('token'), '_token' => \csrf_token()])->with('message','Failure, already done.');
            // return redirect(route('artworks'))->with('token',$request->get('token'));

    }

    public function userProfile() {
        return response()->json(auth()->user());
    }

    public function signout(Request $request)
    {
        auth()->logout();
        JWTAuth::invalidate($request->get('token'));
        session()->forget('token');
        return redirect('/');
    }

}
