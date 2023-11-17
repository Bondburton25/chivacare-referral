<?php

namespace Database\Seeders;

use App\Models\Setting;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SettingSeeder extends Seeder
{
    protected $settings = [
        // [
        //     'key' => 'channelAccessToken',
        //     'value' => 'GtVt/MRkohh1NDhA0Acjwh4rkjHMu8dIXaNjA5F5eKrMkn9muvgkqhiR0vPXfVyFgFfMqU5UAX28VFUrdd6tSeNgTs9HaZe/RxGcM5uLVXKP+0VHvS951/Nnd73cFsYTBglR4mPCN42S1269jWuzFgdB04t89/1O/w1cDnyilFU=',
        // ],
        // [
        //     'key' => 'lineNotifyTokenUserRegister',
        //     'value' => 'l7FZJMWefy8FGVRKMhvrauRDHukwtINeG1bnW0T4H5c',
        // ],
        // [
        //     'key' => 'lineNotifyTokenPatientReferral',
        //     'value' => 'l7FZJMWefy8FGVRKMhvrauRDHukwtINeG1bnW0T4H5c',
        // ],
        // [
        //     'key' => 'liffIdUserRegister',
        //     'value' => '2000588475-zveQ08Zq',
        // ],
        // [
        //     'key' => 'liffIdEmployeesRegister',
        //     'value' => '2000588475-9dGzkaw3',
        // ],
        [
            'key' => 'lineNotifyTokenReportFirstCaseSymptoms',
            'value' => 'MVRk1T9SFiQRviWsEfEMAONSZkACHp2JSnwDveb4TXO',
        ]
    ];

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        foreach($this->settings as $index => $setting)
        {
            $result = Setting::create($setting);
            if (!$result) {
                $this->command->info("Insert failed at record $index.");
                return;
            }
        }
        $this->command->info('Inserted '.count($this->settings). ' records');
    }
}
