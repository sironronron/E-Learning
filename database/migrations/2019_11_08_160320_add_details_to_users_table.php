<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddDetailsToUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('avatar_public_id')->nullable()->after('avatar');
            $table->date('birthday')->nullable()->after('password');
            $table->string('phone')->nullable()->after('birthday');
            $table->string('introduction')->nullable()->after('phone');
            $table->text('biography')->nullable()->after('phone');
            $table->string('facebook_link')->nullable()->after('biography');
            $table->string('twitter_link')->nullable()->after('facebook_link');
            $table->string('youtube_link')->nullable()->after('twitter_link');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('avatar_public_id');
            $table->dropColumn('birthday');
            $table->dropColumn('phone');
            $table->dropColumn('introduction');
            $table->dropColumn('biography');
            $table->dropColumn('facebook_link');
            $table->dropColumn('twitter_link');
            $table->dropColumn('youtube_link');
        });
    }
}
