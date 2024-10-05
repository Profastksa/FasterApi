<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $response = [
            'id'=>$this->id,
            'area_id'=> $this->subArea->area_id,
            'fullname'=> $this->fullname,
            'sub_area_id' => $this->sub_area_id,
            "email"=>$this->email,
            "address"=> $this->address,
            "phone"=> $this->phone,
            "is_active"=> $this->is_active,
            "discount_rate"=> $this->discount_rate,
            "account_balance"=> $this->account_balance,
            'sub_area'=>$this->subArea,
        ];
        return $response;
        return parent::toArray($request);
    }
}
