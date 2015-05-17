<?php

class BadgesTableSeeder extends Seeder {

	public function run() {
        Badge::create([
            'name' => 'Freedom to Share and Connect',
            'description' => '',
            'icon' => 'hackathon-badge-1.png',
            'category_id' => 1,
            'level' => 1
        ]);

        Badge::create([
            'name' => 'Social Value',
            'description' => '',
            'icon' => 'hackathon-badge-2.png',
            'category_id' => 1,
            'level' => 2
        ]);

        Badge::create([
            'name' => 'Free Flow of Information',
            'description' => '',
            'icon' => 'hackathon-badge-3.png',
            'category_id' => 1,
            'level' => 3
        ]);
	}

}
