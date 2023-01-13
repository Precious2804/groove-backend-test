<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class TokenInvestmentResource extends JsonResource
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
            'investmentID' => $this->id,
            'userID' => $this->user_id,
            'amountPaid' => $this->amount_paid,
            'profitMade' => $this->profit,
            'totalAmount' => $this->total_amount,
            'dateCreated' => $this->created_at,
            'token' => new ProjectTokenResource($this->token),
        ];
    }
}
