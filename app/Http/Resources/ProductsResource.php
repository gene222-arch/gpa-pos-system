<?php

namespace App\Http\Resources;

use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductsResource extends JsonResource
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
            'product_name' => $this->product_name,
            'image' => $this->image,
            'description' => $this->description,
            'price' => $this->price,
            'quantity' => $this->quantity,
            'barcode' => $this->barcode,
            'status' => $this->status,
            'created_at' => $this->created_at,
            'image_url' => $this->imagePath($this->image)
        ];
    }

    public function imagePath ($image) {
        return '../../../storage/products/images/' . $image;
    }

}
