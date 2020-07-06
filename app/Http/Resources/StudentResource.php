<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class StudentResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this['id'],
            'course_id' => $this['course_id'],
            'name' => $this['name'],
            'cpf' => $this['cpf'],
            'birth_date' => date_format($this['birth_date'],'Y-m-d'),
            'email' => $this['email'],
            'phone' => $this['phone'],
            'address' => $this['address'],
            'number' => $this['number'],
            'district' => $this['district'],
            'city' => $this['city'],
            'country' => $this['country'],
            'status' => $this['status'] ? 'Ativo': 'Inativo',
        ];
    }
}
