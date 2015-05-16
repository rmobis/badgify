<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddLaravelFacebookSdkColumns extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function(Blueprint $table)
        {
            // Uncomment if the primary id in your you user table is different than the Facebook id
            //$table->bigInteger('facebook_user_id')->unsigned()->index();
            $table->string('access_token')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function(Blueprint $table)
        {
            $table->dropColumn(
                // Uncomment if the primary id in your you user table is different than the Facebook id
                //'facebook_user_id',
                'access_token'
            );
        });
    }

}
