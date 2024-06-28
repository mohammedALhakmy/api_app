<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    use HasFactory;

    protected $fillable = ["about_us", "why_us", "goal", "vision", "about_footer", "ads_text",
        "activities_text", "persons_text", "contact_us_text", "terms_text", "activity_terms",
        "counter1_name", "counter1_count", "counter2_name", "counter2_count", "counter3_name", "counter3_count", "counter4_name", "counter4_count", "address1", "address2", "phone1", "phone2", "whatsapp1", "whatsapp2", "email1", "email2", "facebook", "linkedin",
        "instagram", "youtube", "twitter", "pinterest", "map", "google_play", "app_store", "ad_link_1",
        "ad_link_2"];
}
