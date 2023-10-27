<?php

namespace Database\Seeders;

use App\Models\Setting;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SettingSeeder extends Seeder
{
    protected $settings = [
        [
            'key' => 'channelAccessToken',
            'value' => 'QoUKeR+rPCjaHolU2Cv0kYXvWHx4Xl366O2PqbctqC6zSUv0F9i+U0/iupxgi/WUwxQlcpqP9caAvQzeqbCMYZMXib3TRi9ocUi4iEUiqQKHPynBbUhFQZGV409mw5yBf1cU6zadgXuADifB0kLoMgdB04t89/1O/w1cDnyilFU=',
        ],
        [
            'key' => 'lineNotifyTokenUserRegister',
            'value' => 'O4Y2v1Zw49FL9A40IuLXu35XRKyK1710p6wEf6C07C9',
        ],
        [
            'key' => 'lineNotifyTokenPatientReferral',
            'value' => 'ZDJRAjRTvNjJ9sawi7wHx49D717BojlMZlg5XAoGosd',
        ],
        [
            'key' => 'liffIdUserRegister',
            'value' => '2000626016-NL7a4wJ6',
        ],
        [
            'key' => 'liffIdEmployeesRegister',
            'value' => '2000626016-3m0YB8zW',
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
