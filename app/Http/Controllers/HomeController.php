<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Mbarwick83\Instagram\Instagram;
use Ixudra\Curl\Facades\Curl;

use App\Models\{Configurations, UserInformations};

use App\Helpers\Auth as AuthHelper;

class HomeController extends Controller
{
    private $instagram;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(Instagram $instagram)
    {
        //$this->middleware('auth');
        $this->instagram = $instagram;
        $this->instagram->getLoginUrl();
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, Instagram $instagram)
    {
/*
        $media = "https://api.instagram.com/v1/users/self/media/recent/?access_token=".\Auth::user()->configurations->access_token;

        $data = Curl::to($media)
        ->get();

        dd(json_decode($data, true));

        #Lat = "-18.4153431";
        @long = "-40.2109178";

        $localidades = "https://api.instagram.com/v1/locations/search?lat=48.858844&lng=2.294351&access_token=ACCESS-TOKEN";

*/

      return view('home');
    }

    public function locations(Request $request, Instagram $instagram)
    {
      $localidades = "https://api.instagram.com/v1/locations/search?lat=-18.4153431&lng=-40.2109178&access_token=".\Auth::user()->configurations->access_token;

      $data = Curl::to($localidades)
      ->get();

      $data = json_decode($data, true);

      ##dd($data);

      return view('admin.locations.index')->with('locations', $data['data']);
    }

    public function locationMedias($id, Request $request, Instagram $instagram)
    {

      #https://api.instagram.com/v1/media/search?lat=48.858844&lng=2.294351&access_token=ACCESS-TOKEN#
      #@https://api.instagram.com/v1/locations/".$id."/media/recent?access_token=
      $localidade = "https://api.instagram.com/v1/media/search?lat=48.858844&lng=2.294351&access_token=".\Auth::user()->configurations->access_token;

      $data = Curl::to($localidade)
      ->get();

      $data = json_decode($data, true);

      dd($data);

      return view('admin.locations.index')->with('locations', $data['data']);
    }

    // Get access token on callback, once user has authorized via above method
    public function callback(Request $request, Instagram $instagram)
    {
    	$response = $instagram->getAccessToken($request->code);
    	// or $response = Instagram::getAccessToken($request->code);

        if (isset($response['code']) == 400)
        {
            throw new \Exception($response['error_message'], 400);
        }

        return $response['access_token'];
    }

    public function autenticationServer(Request $request)
    {
        AuthHelper::setUserInformations($request, $this->instagram);

        return redirect()->route('home');
    }

    public function redirectToAuth()
    {
        $client_id = '485375df1191478181614bdadff68ffe';

        $redirect_uri = config('app.redirect_uri');

        $requestAuth = "https://api.instagram.com/oauth/authorize/?client_id=%s&redirect_uri=%s&response_type=code&scope=basic+public_content+follower_list+comments+relationships+likes";

        $request = sprintf($requestAuth, $client_id, $redirect_uri);

        dd($request);

        return redirect($request);
    }

    public function profile()
    {dd(\Auth::user()->informations);
        return view('admin.user.profile')
        ->with('user', \Auth::user());
    }

    public function follows(Request $request)
    {
        $url = "https://api.instagram.com/v1/users/self/follows?access_token=". \Auth::user()->configurations->access_token;
/*
      $response = Curl::to($url)
      ->get();

      dd($response);
*/

        #$data = $this->instagram->get('/v1/users/self/follows/', ['access_token' => \Auth::user()->configurations->access_token]);


        $media = "https://api.instagram.com/v1/users/self/media/recent/?access_token=".\Auth::user()->configurations->access_token;
/*
        $data = Curl::to($media)
        ->get();
*/
        #$data = $this->instagram->get($media);

        //dd(json_decode($data, 1));

        return view('admin.people.follows');
    }

    public function person($id)
    {
        $medias = "https://api.instagram.com/v1/users/".$id."/media/recent/?access_token=".\Auth::user()->configurations->access_token;

        $data = Curl::to($medias)->get();

        $data = json_decode($data, true);

        dd($data);

        return view('admin.person.profile');
    }
}
