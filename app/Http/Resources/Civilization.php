<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class Civilization extends JsonResource
{
  /**
   * Transform the resource into an array.
   *
   * @param  \Illuminate\Http\Request  $request
   * @return array
   */
  public function toArray($request)
  {
    return [
      'id' => $this->id,
      'name' => $this->name,
      'expansion' => $this->expansion,
      'army_type' => $this->army_type,
      //'unique_unit' => $this->unique_unit,
      //'unique_tech' => $this->unique_tech,
      'team_bonus' => $this->team_bonus,
      'created_at' => $this->created_at,
      'updated_at' => $this->updated_at,
    ];
  }
}
