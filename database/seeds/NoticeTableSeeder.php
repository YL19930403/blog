<?php

use Illuminate\Database\Seeder;

class NoticeTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        DB::table('t_notice')->insert([
            'content' => '我是timo',
            'status'  => 1 ,
            'op_id'   => 12,
            'publish_start_time' => '2018-09-19 23:11:22',
            'publish_end_time' => '2018-09-20 11:10:02',
            'create_time' => '2018-09-19 14:33:19',
            'modify_time' => '2018-09-21 15:13:19',

        ]);
    }
}
