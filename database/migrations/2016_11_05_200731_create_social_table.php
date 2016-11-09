<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSocialTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('socials', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('label');
            $table->timestamps();
        });

        $socials = [
            [
                'label' => 'Facebook',
                'name' => 'facebook'
            ],
            [
                'label' => 'Twitter',
                'name' => 'twitter'
            ],
            [
                'label' => 'Instagram',
                'name' => 'instagram'
            ],
        ];

        foreach ($socials as $social) {
            App\Social::create($social);
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('socials');
    }
}
