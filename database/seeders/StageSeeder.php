<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class StageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $stages = [
            ['name' => 'ส่งข้อมูลคนไข้สำเร็จ รอ CVC ติดต่อคนไข้', 'step' => 1],
            ['name' => 'CVC ติดต่อญาติคนไข้เรียบร้อย', 'step' => 2],
            ['name' => 'ญาติคนไข้เข้าดูสถานที่เรียบร้อย', 'step' => 3],
            ['name' => 'ญาติคนไข้ตัดสินใจ เข้าพัก/ไม่เข้าพัก', 'step' => 4],
            ['name' => 'เข้าพัก วันเวลาที่', 'step' => 5],
            ['name' => 'รับตัวคนไข้', 'step' => 6],
            ['name' => 'คนไข้อยู่กับ CVC 1 เดือน รอทำจ่าย (กรณีไม่อยู่จะขึ้นว่าลูกค้าอยู่ครบ 1 เดือน)', 'step' => 7],
            ['name' => 'คนไข้ อยู่กับ CVC 2 เดือน รอทำจ่าย', 'step' => 8],
            ['name' => 'คนไข้อยู่กับ cvc ครบ 3 เดือน รอทำจ่าย', 'step' => 9]
        ];
        DB::table('stages')->insert($stages);
    }
}
