<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SettingResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
          'about us' => $this->about_us,
          'why us' => $this->why_us,
          'goal' => $this->goal,
          'vision' => $this->vision,
          'about footer' => $this->about_footer,
          'ads text' => $this->ads_text,
          'activities text' => $this->activities_text,
          'persons text' => $this->persons_text,
          'contact us text' => $this->contact_us_text,
          'terms text' => $this->terms_text,
          'activity terms' => $this->activity_terms,
          'counter1_name' => $this->counter1_name,
        ];
    }
}
