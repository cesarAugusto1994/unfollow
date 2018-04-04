<?php

namespace App\Helpers;

use Illuminate\Http\Request;
use Mbarwick83\Instagram\Instagram;
use Ixudra\Curl\Facades\Curl;

use App\Models\{Configurations, UserInformations, UserCounts, UserMedias, UsersInPhoto, People, MediaImages, MediaLocation, Author};

/**
 *
 */
class Auth
{
    public static function setUserInformations(Request $request, Instagram $instagram)
    {
        $data = $request->request->all();

        $user = \Auth::user();

        if($request->user()->configurations->access_token) {
          //return;
        }

        $config = Configurations::where('user_id', \Auth::user()->id)->get()->first();
        $config->code = $data['code'] ?? '';
        $config->save();

        $accessToken = "https://api.instagram.com/oauth/access_token";

        $response = Curl::to($accessToken)
        ->withData(
          [
            'client_id' => $config->client_id,
            'client_secret' => $config->client_secret,
            'redirect_uri' => $config->redirect_uri,
            'grant_type' => 'authorization_code',
            'code' => $config->code])
        ->post();

        dd($response);

        $userData = json_decode($response, true);

        if(isset($userData['code']) && $userData['code'] == 400) {
            return;
        }

        $config = Configurations::where('user_id', \Auth::user()->id)->get()->first();
        $config->access_token = $userData['access_token'] ?? '';
        $config->save();

        $info = UserInformations::where('user_id', \Auth::user()->id)->get()->first();
        $info->api_id = $userData['user']['id'];
        $info->username = $userData['user']['username'];
        $info->full_name = $userData['user']['full_name'];
        $info->profile_picture = $userData['user']['profile_picture'];
        $info->bio = $userData['user']['bio'];
        $info->website = $userData['user']['website'];
        $info->is_business = $userData['user']['is_business'];
        $info->save();

        $data = $instagram->get('v1/users/self', ['access_token' => $userData['access_token']]);

        $count = UserCounts::where('user_id', \Auth::user()->id)->get()->first();
        $count->media = $data['data']['counts']['media'];
        $count->follows = $data['data']['counts']['follows'];
        $count->followed_by = $data['data']['counts']['followed_by'];
        $count->save();

        $medias = "https://api.instagram.com/v1/users/self/media/recent/?access_token=".$userData['access_token'];

        $data = Curl::to($medias)->get();

        $data = json_decode($data, true);

        if(!isset($data['data'])) {
          return;
        }

        $data = $data['data'];

        #dd($data);

        foreach($data as $dados) {

            $hasAuthor = Author::where('api_id', $dados['user']['id'])->get();

            if($hasAuthor->isEmpty()) {
              $author = new Author();
              $author->api_id = $dados['user']['id'];
              $author->username = $dados['user']['username'];
              $author->full_name = $dados['user']['full_name'];
              $author->profile_picture = $dados['user']['profile_picture'];
              $author->save();
            } else {
              $author = $hasAuthor->first();
            }

            $uMedias = UserMedias::where('api_id', $dados['id'])->get();

            if($uMedias->isNotEmpty()) {
               continue;
            }

            $userMedias = new UserMedias();
            $userMedias->user_id = $user->id;
            $userMedias->author_id = $author->id;
            $userMedias->api_id = $dados['id'];
            $userMedias->caption = $dados['caption']['text'];
            $userMedias->likes = $dados['likes']['count'];
            $userMedias->comments = $dados['comments']['count'];
            $userMedias->filter = $dados['filter'];
            $userMedias->type = $dados['type'];
            $userMedias->link = $dados['link'];
            #$userMedias->created_time = $dados['created_time'];
            $userMedias->save();

            $mediaLocation = new MediaLocation();
            $mediaLocation->media_id = $userMedias->id;
            $mediaLocation->api_id = $dados['location']['id'];
            $mediaLocation->latitude = $dados['location']['latitude'];
            $mediaLocation->longitude = $dados['location']['longitude'];
            $mediaLocation->name = $dados['location']['name'];
            $mediaLocation->save();

            $usersInPhoto = $dados['users_in_photo'];

            foreach($usersInPhoto as $singleUser) {

                $person = new People();
                $person->api_id = $singleUser['user']['id'] ?? '';
                $person->username = $singleUser['user']['username'] ?? '';
                $person->full_name = $singleUser['user']['full_name'] ?? '';
                $person->profile_picture = $singleUser['user']['profile_picture'] ?? '';
                $person->save();

                $userInPhoto = new UsersInPhoto();
                $userInPhoto->media_id = $userMedias->id;
                $userInPhoto->person_id = $person->id;
                $userInPhoto->position_x = $singleUser['position']['x'];
                $userInPhoto->position_y = $singleUser['position']['y'];
                $userInPhoto->save();
            }

            $images = $dados['images'];

            foreach($images as $type => $image) {

                $mediaImage = new MediaImages();
                $mediaImage->media_id = $userMedias->id;
                $mediaImage->type = $type;
                $mediaImage->width = $image['width'];
                $mediaImage->height = $image['height'];
                $mediaImage->url = $image['url'];
                $mediaImage->save();
            }
        }
    }
}
