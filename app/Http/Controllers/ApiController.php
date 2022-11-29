<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Request;
use Phpfastcache\Helper\Psr16Adapter;
use InstagramScraper\Instagram;

class ApiController extends Controller
{
    public function getAccountById()
    {
        $account = (new \InstagramScraper\Instagram(new \GuzzleHttp\Client()))->getAccountById(3);
        return $account;
    }

    public function getAccountByName(Request $request)
    {
        try {

            $instagram = new \InstagramScraper\Instagram(new \GuzzleHttp\Client());

            $account = $instagram->getAccountInfo('besokseninco');

            $data = [
                'id' => $account->getId(),
                'username' => $account->getUsername(),
                'full_name' => $account->getFullName(),
                'biography' => $account->getBiography(),
                'profile_picture_url' => $account->getProfilePicUrl(),
                'external_url' => $account->getExternalUrl(),
                'number_of_published_posts' => $account->getMediaCount(),
                'number_of_followers' => $account->getFollowsCount(),
                'number_of_follows' => $account->getFollowedByCount(),
                'is_private' => $account->isPrivate(),
                'is_verified' => $account->isVerified(),
            ];
            return $data;
        } catch (\Throwable $th) {
            return $th->getMessage();
        }
    }

    public function getAccountFollowers()
    {
        $instagram = Instagram::withCredentials(new \GuzzleHttp\Client(), 'handaa.hijab', 'hijab123', new Psr16Adapter('Files'));
        $instagram->setUserAgent('User-Agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:78.0) Gecko/20100101 Firefox/78.0');
        $instagram->login(false, true);
        $instagram->saveSession();
        sleep(2); // Delay to mimic user

        $username = 'handaa.hijab';
        $followers = [];
        $account = $instagram->getAccount($username);
        sleep(1);
        $followers = $instagram->getFollowers($account->getId(), 1000, 100, true); // Get 1000 followers of 'kevin', 100 a time with random delay between requests
        return '<pre>' . json_encode($followers) . '</pre>';
    }

    public function getMediaByUsername()
    {

        $instagram = new \InstagramScraper\Instagram(new \GuzzleHttp\Client());
        $medias = $instagram->getMedias('besokseninco', 4);

        $medias;
        $media = [];
        foreach ($medias as $med) {
            $account = $med->getOwner();
            $media[] = [
                'id' => $med->getId(),
                'shortcode' => $med->getShortCode(),
                'created_at' => $med->getCreatedTime(),
                'caption' => $med->getCaption(),
                'number_of_comments' => $med->getCommentsCount(),
                'number_of_likes' => $med->getLikesCount(),
                'link' => $med->getLink(),
                'image_high_resolution_url' => $med->getImageHighResolutionUrl(),
                'media_type' => $med->getType(),
                'account_id' => $account->getId(),
                'username' => $account->getUsername(),
                'full_name' => $account->getFullName(),
                'profile_pic_url' => $account->getProfilePicUrl(),

            ];
        }

        return $media;
    }

    public function getFeed()
    {
        $instagram  = Instagram::withCredentials(new \GuzzleHttp\Client(), 'user', 'pass', new Psr16Adapter('Files'));
        $instagram->setUserAgent('User-Agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:78.0) Gecko/20100101 Firefox/78.0');
        $instagram->login(false, true);
        $instagram->login();
        $instagram->saveSession();

        $posts  = $instagram->getFeed();

        foreach ($posts as $post) {
            echo $post->getImageHighResolutionUrl() . "\n";
        }
    }

    public function getInbox()
    {
        $username = 'handaa.hijab';
        $password = 'hijab123';

        $instagram  = Instagram::withCredentials(
            new \GuzzleHttp\Client(),
            $username,
            $password,
            new Psr16Adapter('Files')
        );

        $instagram->login();

        $instagram->saveSession();

        $instagram->pending();
        $inbox = $instagram->getInbox();
        $instagram->seenInbox();

        return $inbox;
    }

    public function searchAccountByUsername(){
        
    }
}
