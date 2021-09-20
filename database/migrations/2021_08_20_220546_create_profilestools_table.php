<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * Class CreateProfilestoolsTable.
 */
class CreateProfilestoolsTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('profiles_tools', function(Blueprint $table) {
            $table->increments('id');
            $table->integer('profiles_id');
            $table->integer('tools_id');
            $table->integer('organization_id');
            $table->timestamps();
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('profiles_tools');
	}
}
