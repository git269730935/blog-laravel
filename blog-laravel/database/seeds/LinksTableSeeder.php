<?php

use Illuminate\Database\Seeder;

class LinksTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            [
                'link_name' => '腾讯课堂',
                'link_title' => '腾讯旗下提供学习视频的网站',
                'link_url' => 'https://ke.qq.com',
                'link_order' => 1
            ],
            [
                'link_name' => '后盾网',
                'link_title' => 'PHP培训机构',
                'link_url' => 'http://www.houdunwang.com',
                'link_order' => 2
            ],
            [
                'link_name' => '我的世界中文论坛',
                'link_title' => '我的世界官方中文论坛',
                'link_url' => 'http://www.mcbbs.net',
                'link_order' => 3
            ]
        ];
        DB::table('links')->insert($data);
    }
}
