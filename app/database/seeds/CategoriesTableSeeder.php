<?php

class CategoriesTableSeeder extends Seeder {

	public function run() {
		Category::create([
            'name' => 'Facebook Hackathon',
            'description' => 'The main goal of this challenge is to prove that we, programmers, can live in the real world and interact with it. We are humans too and we don’t talk only in binary - at least most of us. We are as normal as the other people - we take pictures and post them on Facebook, we travel, we enjoy our moments.',
            'background' => 'facebook-hackathon-bg.png'
			]);
	}

}
