<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Artwork;
use App\Models\Bid;
use JWTAuth;

class NewArtworkController extends Controller
{
    //
    public function index(Request $request)
    {	
        // $currenttime = time();
        // $currenttime = $currenttime - 86400;
        // $artworks = Artwork::where('sold', false)
        //     ->where('created_at', '>', date('Y-m-d h:i:s', $currenttime))
        //     ->get();
        $type = $request->type;
        if($type)
            $artworks = Artwork::where('type', $type)->orderBy('created_at', 'desc')->get();
        else
        {
            $artworks = Artwork::orderBy('created_at', 'desc')->get();
            $type = 0;
        }
        $firstbidtimes = collect($artworks)->map(function ($artwork) {
            if($artwork->firstbidtime)
                return $artwork->firstbidtime->created_at;
            else return null;
        });

        // $token = $request->get('token');
        // $user = JWTAuth::toUser($token);
        // echo $firstbidtimes;exit;
        // $artworks = $artworks->map(function ($artwork) {
        //     $artwork['bidable'] = true;
        //     if($artwork->user_id==$user->id)
        //         $artwork->bidable = false;
        //     return $artwork;
        // });
        // foreach ($artworks as $key => $artwork) {
        //     $artworks[$key]['bidable'] = true;
        //     if($artwork->user_id==$user->id){
        //         $artworks[$key]['bidable'] = false;
        //     }
        //     // if($artwork->created_at < date('Y-m-d h:i:s', date('Y-m-d h:i:s', $currenttime))){
        //     //     $artworks[$key]['bidable'] = false;
        //     // }
        // }
        $nav_type = '1';
        return view('newartworks', compact("artworks", "nav_type", "type", "firstbidtimes"));
    }

    public function account(Request $request)
    {	
        $token = $request->get('token');
        $user = JWTAuth::toUser($token);
        $bids = Bid::where('user_id', $user->id)->orderBy('created_at', 'desc')->get();
        // foreach ($bids as $key => $bid) {
        //     $bids[$key]['count'] = $bid->artwork->count();
        // }
        $nav_type = '0';
        return view('account', compact("bids", "nav_type"));
    }

    // public function index_notmet(Request $request)
    // {	
    //     $currenttime = time();
    //     $currenttime = $currenttime - 86400;
    //     $artworks = Artwork::where('sold', false)
    //         ->where('created_at', '>', date('Y-m-d h:i:s', $currenttime))
    //         ->get();
    //     return view('artworks', compact("artworks"));
    // }

    // public function index_sold(Request $request)
    // {	
    //     $artworks = Artwork::where('sold', true)
    //         ->get();
    //     return view('artworks', compact("artworks"));
    // }

    public function artwork_id(Request $request)
    {	
        $artwork = Artwork::where('id', $request->get('art_id'))->first();
        $bids = Bid::where('artwork_id', $request->get('art_id'))->get();
        $nav_type = "1";
        $type = "0";
        return view('newartworkById', compact("artwork", "bids", "nav_type", "type"));
    }

    public function bidart(Request $request)
    {	
        $bid = new Bid;
        $bid->artwork_id = $request->get('artwork_id');
        // echo $request;exit;
        $token = $request->get('token');
        $user = JWTAuth::toUser($token);
        if(Bid::where('user_id', $user->id)->where('artwork_id', $request->get('artwork_id'))->first()){
            return redirect()->route('artworks', ['token' => session('token'), '_token' => \csrf_token()], 302)->with('message','Failure, already done.');
            // return response()->route('artworks')->header('Authorization', 'Bearer '.session('token'));
            // return back()->with('token', session('token'))->with('message','Failure, already done.');
            exit;
        }
            // return redirect()->route('/');
        $bid->user_id = $user->id;
        $bid->save();
        return redirect()->route('artworks', ['token' => session('token'), '_token' => \csrf_token()], 302)->with('message','Success, Good luck!');
            // $artwork = Artwork::where('id', $request->get('art_id'))->first();
        // $bids = Bid::where('artwork_id', $request->get('art_id'))->get();
        // return back()->with('message','Success, Good luck!');
    }

    public function findByUser(Request $request)
    {	
	
        // Check validation
            // $this->validate($request, [
            //     'ethid' => 'required',     
            // ]);
        
        // echo $request->get('publicAddress');exit;
        $publicAddress = $request->json('publicAddress');
        $token = $request->get('token');
        echo $token;
        $user = JWTAuth::toUser($token);
        echo $user;
        exit;
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

    public function upload(Request $request)
    {
    	$this->validate($request, [
    		'title' => 'required',
    		// 'price' => 'required',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);
        // echo $request->title; 
        // echo $request->price; 
        // echo $request->image; 
        // exit; 


        $input['image'] = time().'.'.$request->image->getClientOriginalExtension();
        $request->image->move(public_path('uploads'), $input['image']);

        $token = session('token');
        $user = JWTAuth::toUser($token);

        $input['title'] = $request->title;
        $input['price'] = $request->price;
        $input['user_id'] = $user->id;
        Artwork::create($input);


    	return back()
    		->with('message', $input['price'] );//'Image Uploaded successfully.'
    }


    /**
     * Remove Image function
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
    	Artwork::find($id)->delete();
    	return back()
    		->with('success','Image removed successfully.');	
    }
}
