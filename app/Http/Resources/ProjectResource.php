<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ProjectResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'projectID' => $this->id,
            'projectName' => $this->project_name,
            'numberOfTokensSales' => $this->number_of_sales,
            'totalAmountDerived' => $this->amount,
            'dateCreated' => $this->created_at,
        ];
    }
}
