<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
   protected array $withoutKeys = [
       'created_at',
       'updated_at',
       'password'
   ];
}
