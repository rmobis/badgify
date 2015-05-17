<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddAmountAndDoneFlagToAchievementsPivotTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('achievement_user', function(Blueprint $table)
		{
			$table->integer('amount');
			$table->boolean('done');
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
			$table->dropColumn('amount');
			$table->dropColumn('done');
		});
	}

}
