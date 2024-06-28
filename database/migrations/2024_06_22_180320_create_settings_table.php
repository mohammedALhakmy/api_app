<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('settings', function (Blueprint $table) {
            $table->id();
            $table->text("about_us")->nullable();
            $table->text("why_us")->nullable();
            $table->text("goal")->nullable();
            $table->text("vision")->nullable();
            $table->text("about_footer")->nullable();
            $table->text("ads_text")->nullable();
            $table->text("activities_text")->nullable();
            $table->text("persons_text")->nullable();
            $table->text("contact_us_text")->nullable();
            $table->text("terms_text")->nullable();
            $table->text("activity_terms")->nullable();
            $table->text("counter1_name")->nullable();
            $table->bigInteger("counter1_count")->nullable();
            $table->text("counter2_name")->nullable();
            $table->bigInteger("counter2_count")->nullable();
            $table->text("counter3_name")->nullable();
            $table->bigInteger("counter3_count")->nullable();
            $table->text("counter4_name")->nullable();
            $table->bigInteger("counter4_count")->nullable();
            $table->text("address1")->nullable();
            $table->text("address2")->nullable();
            $table->text("phone1")->nullable();
            $table->text("phone2")->nullable();
            $table->text("whatsapp1")->nullable();
            $table->text("whatsapp2")->nullable();
            $table->text("email1")->nullable();
            $table->text("email2")->nullable();
            $table->text("facebook")->nullable();
            $table->text("linkedin")->nullable();
            $table->text("instagram")->nullable();
            $table->text("youtube")->nullable();
            $table->text("twitter")->nullable();
            $table->text("pinterest")->nullable();
            $table->text("map")->nullable();
            $table->text("google_play")->nullable();
            $table->text("app_store")->nullable();
            $table->text("ad_link_1")->nullable();
            $table->text("ad_link_2")->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('settings');
    }
};
