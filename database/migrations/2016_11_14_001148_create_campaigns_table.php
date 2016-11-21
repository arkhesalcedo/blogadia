<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCampaignsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('campaigns', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id')->unsigned();
            $table->string('name');
            $table->text('description');
            $table->text('content');
            $table->integer('duration');
            $table->integer('number_of_bloggers')->default(1)->unsigned();
            $table->decimal('budget', 13, 2)->default(0.00);
            $table->softDeletes();
            $table->timestamps();
        });

        Schema::create('uploads', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('campaign_id')->unsigned();
            $table->string('path');
            $table->string('type');
            $table->timestamps();
        });

        Schema::create('subscriptions', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name')->unique();
            $table->string('label')->unique();
            $table->timestamps();
        });

        $subscriptions = [
            [
                'label' => 'Free',
                'name' => 'free'
            ],
            [
                'label' => 'Paid',
                'name' => 'paid'
            ]
        ];

        foreach ($subscriptions as $subscrption) {
            App\Subscription::create($subscrption);
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('campaigns');
        Schema::dropIfExists('uploads');
        Schema::dropIfExists('subscriptions');
    }
}
