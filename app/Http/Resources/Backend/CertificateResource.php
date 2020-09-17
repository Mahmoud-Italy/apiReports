<?php

namespace App\Http\Resources\Backend;

use App\Models\Setting;
use App\Models\CertificateCategory;
use App\Http\Resources\Backend\CertificateCategoryResource;
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
            'image'        => ($this->image) ? request()->root() . '/uploads/' . $this->image->url : NULL,

            'bgSubTitle1'   => $this->bgSubTitle1,
            'bgTitle1'      => $this->bgTitle1,
            'bgColor1'      => $this->bgColor1,
            'body1'         => $this->body1,

            'cat1_name'      => Setting::select('body1')->where('id', 6)->first(),
            'cat2_name'      => Setting::select('body2')->where('id', 6)->first(),
            'cat3_name'      => Setting::select('body3')->where('id', 6)->first(),

            'has_download'   => (int)$this->has_download,
            'download_name'  => $this->download_name,
            'download_file'  => ($this->pdf) ? request()->root() . '/uploads/' . $this->pdf->url : NULL,
            'download_image' => ($this->image_pdf) ? request()->root() . '/uploads/' . $this->image_pdf->url : NULL,


            'image2'        => ($this->image2) ? request()->root() .'/uploads/' . $this->image2->url : NULL,
            'bgSubTitle2'   => $this->bgSubTitle2,
            'bgTitle2'      => $this->bgTitle2,
            'bgColor2'      => $this->bgColor2,
            'body2'         => $this->body2,
            'hint2'         => $this->hint2,
            'duration1'      => $this->duration1,
            'duration2'      => $this->duration2,
            'duration3'      => $this->duration3,


            'image3'        => ($this->image3) ? request()->root() .'/uploads/' . $this->image3->url : NULL,
            'dTitle'        => $this->dTitle,

            
            'cTitle'        => $this->cTitle,
            'cBody1'         => $this->cBody1,
            'cBody2'         => $this->cBody2,
            'cBody3'         => $this->cBody3,
            'cBody4'         => $this->cBody4,

            'image5_1'      => ($this->image5_1) ? request()->root() .'/uploads/' . $this->image5_1->url : NULL,
            'image5_2'      => ($this->image5_2) ? request()->root() .'/uploads/' . $this->image5_2->url : NULL,
            'image5_3'      => ($this->image5_3) ? request()->root() .'/uploads/' . $this->image5_3->url : NULL,
            'image5_4'      => ($this->image5_4) ? request()->root() .'/uploads/' . $this->image5_4->url : NULL,
            

            'cat1'          => 
            CertificateCategoryResource::collection(CertificateCategory::where('cat_id', 1)->get()),
            'cat2'          => 
            CertificateCategoryResource::collection(CertificateCategory::where('cat_id', 2)->get()),
            'cat3'          => 
            CertificateCategoryResource::collection(CertificateCategory::where('cat_id', 3)->get()),
        ];
    }
}
