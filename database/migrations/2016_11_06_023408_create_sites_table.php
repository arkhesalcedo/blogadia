<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSitesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('categories', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->timestamps();
        });

        $categories = [
            'Art',
            'Books/Mags',
            'Books/Mags',
            'Culture',
            'Crafts',
            'Education',
            'Environment',
            'Fashion',
            'Food',
            'Gadget',
            'Games',
            'Health/Medicine',
            'Home',
            'Humor',
            'Internet',
            'Kids',
            'Marketing',
            'Media',
            'Men',
            'Military',
            'Movies/Film',
            'Music',
            'Parenthood',
            'Pets',
            'Photography',
            'Religion',
            'Science',
            'Sports',
            'Tech',
            'Television',
            'Travel',
            'Women',
            'Other'
        ];

        foreach ($categories as $category) {
            App\Category::create(['name' => $category]);
        }

        Schema::create('sites', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id')->unsigned();
            $table->string('name');
            $table->string('url');
            $table->integer('category_id')->unsigned();
            $table->text('description')->nullable();
            $table->string('image_path')->nullable();
            $table->integer('age')->unsigned();
            $table->integer('pageviews')->unsigned();
            $table->integer('posts_per_month')->unsigned();
            $table->integer('price')->unsigned();
            $table->boolean('google_analytics')->default(false);
            $table->boolean('quantcast')->default(false);
            $table->boolean('commit')->default(true);
            $table->boolean('verified')->default(false);
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
        Schema::dropIfExists('sites');
        Schema::dropIfExists('categories');
    }
}
