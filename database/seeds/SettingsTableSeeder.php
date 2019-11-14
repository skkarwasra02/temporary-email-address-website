<?php

use Illuminate\Database\Seeder;
use App\Models\Setting;

class SettingsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Characters that can be used to generate random username
        $setting = new Setting;
        $setting->setting_name = 'random_username_characters';
        $setting->setting_value = 'abcdefghijklmnopqrstuvwxyz';
        $setting->save();

        // Length of random username
        $setting = new Setting;
        $setting->setting_name = 'random_username_length';
        $setting->setting_value = 6;
        $setting->save();

        // Mail server
        $setting = new Setting;
        $setting->setting_name = 'mail_server';
        $setting->setting_value = '';
        $setting->save();

        // Delete old attachments (hours)
        $setting = new Setting;
        $setting->setting_name = 'delete_attachments';
        $setting->setting_value = '1';
        $setting->save();

        // Security key
        $setting = new Setting;
        $setting->setting_name = 'security_key';
        $setting->setting_value = bin2hex(openssl_random_pseudo_bytes(16));
        $setting->save();
    }
}
