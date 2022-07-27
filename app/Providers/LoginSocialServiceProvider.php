<?php

namespace App\Providers;
use vanhenry\helpers\helpers\SettingHelper;
use Illuminate\Support\ServiceProvider;

class LoginSocialServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        $config['facebook'] = [
            'client_id' => SettingHelper::getSetting('FB_APPID'),
            'client_secret' => SettingHelper::getSetting('FB_APP_SECRET'),
            'redirect' => url('callback-facebook'),
        ];
        $config['google'] = [
            'client_id' => SettingHelper::getSetting('GG_APPID'),
            'client_secret' => SettingHelper::getSetting('GG_APP_SECRET'),
            'redirect' => url('callback-google'),
        ];
        $captcha = [
            'secret' => SettingHelper::getSetting('GOOGLE_RECAPTCHA_SECRET_KEY'),
            'sitekey' => SettingHelper::getSetting('GOOGLE_RECAPTCHA_SITE_KEY'),
            'options' => [
                'timeout' => 30,
            ]
        ];

        \Config::set('services', $config);
        \Config::set('captcha', $captcha);
    }
}
