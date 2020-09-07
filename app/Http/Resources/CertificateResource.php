<?php

namespace App\Http\Resources;

use App\Models\CertificateCategory;
use App\Http\Resources\CertificateCategoryResource;
use Illuminate\Http\Resources\Json\JsonResource;

class CertificateResource extends JsonResource
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
            'id'            => $this->id,
            'image1'        => ($this->image1) ? request()->root() . '/uploads/' . $this->image1->url : NULL,
            'bgSubTitle1'   => $this->bgSubTitle1,
            'bgTitle1'      => $this->bgTitle1,
            'bgColor1'      => $this->bgColor1,
            'body1'         => $this->body1,
            'has_download'  => (boolean)$this->has_download,
            'download_name' => $this->download_name,
            'pdf_file'      => ($this->image_pdf) ? request()->root() .'/uploads/' . $this->image_pdf->url : NULL,


            'image2'        => ($this->image2) ? request()->root() .'/uploads/' . $this->image2->url : NULL,
            'bgSubTitle2'   => $this->bgSubTitle2,
            'bgTitle2'      => $this->bgTitle2,
            'bgColor2'      => $this->bgColor2,
            'body2'         => $this->body2,
            'hint2'         => $this->hint2,
            'duration'      => $this->duration,


            'image3'        => ($this->image3) ? request()->root() .'/uploads/' . $this->image3->url : NULL,
            'dTitle'        => $this->dTitle,

            'image4'        => ($this->image4) ? request()->root() .'/uploads/' . $this->image4->url : NULL,
            'cTitle'        => $this->cTitle,
            'cBody'         => $this->cBody,
            

            'cat1'          => 
            CertificateCategoryResource::collection(CertificateCategory::where('cat_id', 1)->get()),
            'cat2'          => 
            CertificateCategoryResource::collection(CertificateCategory::where('cat_id', 2)->get()),
            'cat3'          => 
            CertificateCategoryResource::collection(CertificateCategory::where('cat_id', 3)->get()),
        ];
    }
}
