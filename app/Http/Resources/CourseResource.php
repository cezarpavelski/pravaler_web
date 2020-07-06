<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class CourseResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this['id'],
            'institution_id' => $this['institution_id'],
            'name' => $this['name'],
            'duration' => $this['duration'],
            'status' => $this['status'] ? 'Ativo': 'Inativo',
        ];
    }
}
