<?php

class AchievementsTableSeeder extends Seeder {

	public function run() {
        Achievement::create([
            'name' => 'I\'m here...',
            'description' => 'Check-in at the Facebook São Paulo building.',
            'icon' => '',
            'badge_id' => 1,
            'rules' => 'place:298042960354301',
            'amount' => 1
        ]);

        Achievement::create([
            'name' => '...for the food',
            'description' => 'Post a picture of you or your teammates eating pizza using the #pizzaHack hashtag.',
            'icon' => '',
            'badge_id' => 1,
            'rules' => 'hasPicture;hashtag:pizzaHack',
            'amount' => 1
        ]);

        Achievement::create([
            'name' => 'Make a friend',
            'description' => 'Take a picture with one of the Facebook employees! Make sure to tag him/her on your post.',
            'icon' => '',
            'badge_id' => 2,
            'rules' => 'hasPicture;taggedPeople:Victor Lassance:Laura Zaslavsky:Miguel Gaiowski:Leonardo Marchetti:Emma Edwards',
            'amount' => 1
        ]);

        Achievement::create([
            'name' => 'Move Fast',
            'description' => 'Take a picture of you and your teammates working on your hackathon project. Use the hashtags #teamWork and #<temName>.',
            'icon' => '',
            'badge_id' => 2,
            'rules' => 'hasPicture;hashtag:teamWork;taggedPeopleAmount:3',
            'amount' => 1
        ]);

        Achievement::create([
            'name' => 'Live The Moment',
            'description' => 'Post a video with at least 10 seconds and mark the Facebook São Paulo building as location.',
            'icon' => '',
            'badge_id' => 3,
            'rules' => 'hasVideo;videoLength:10;place:298042960354301',
            'amount' => 1
        ]);
	}

}
