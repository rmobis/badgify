<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddAchievedAtToAchievementUserTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('achievement_user', function(Blueprint $table)
		{
			$table->timestamp('achieved_at');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('achievement_user', function(Blueprint $table)
		{
			$table->dropColumn('achieved_at');
		});
	}

}
