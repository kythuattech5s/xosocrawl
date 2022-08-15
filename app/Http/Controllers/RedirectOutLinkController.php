<?php
namespace App\Http\Controllers;

use App\Models\BannerGdn;
use App\Models\GuessLinkAds;
use Crawler;

class RedirectOutLinkController extends Controller
{	
    public function outBanner()
    {
        if(Crawler::isCrawler()) {
            return redirect('/');
        }
        if (!isset(request()->token)) return redirect()->to('/');
        $bannerGdn = BannerGdn::where('token',request()->token)->first();
        if (!isset($bannerGdn)) return redirect()->to('/');
        return redirect($bannerGdn->link);
    }
    public function outGuessLink()
    {
        if(Crawler::isCrawler()) {
            return redirect('/');
        }
        if (!isset(request()->token)) return redirect()->to('/');
        $guessLinkAds = GuessLinkAds::where('token',request()->token)->first();
        if (!isset($guessLinkAds)) return redirect()->to('/');
        return redirect($guessLinkAds->link);
    }
}