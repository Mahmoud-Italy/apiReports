<?php

namespace App\Http\Resources\Frontend;

use App\Models\CertificateCategory;
use App\Models\CertificateProduct;
use App\Http\Resources\Frontend\CertificateCategoryResource;
use App\Http\Resources\Frontend\CertificateProductResource;
use Illuminate\Http\Resources\Json\JsonResource;

class OurCertificateResource extends JsonResource
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
            'background1' => ($this->image1) ? request()->root() . '/uploads/' . $this->image1->url : NULL,
            'bgTitle'    => $this->bgTitle1,
            'bgSubTitle' => $this->bgSubTitle1,
            'bgColor1'   => $this->bgColor1,
            'body1'      => $this->body1,

            'has_download'  => (boolean)$this->has_download,
            'download_name' => $this->download_name,
            'download_file' => ($this->image_pdf) ? request()->root() . '/uploads/' . $this->image_pdf->url : NULL,


            'background2'  => ($this->image2) ? request()->root() . '/uploads/' . $this->image2->url : NULL,
            'bgTitle2'     => $this->bgTitle2,
            'bgSubTitle2'  => $this->bgSubTitle2,
            'bgColor2'     => $this->bgColor2,
            'body2'        => $this->body2,
            'hint2'        => $this->hint2,

            'certificates_1' => CertificateCategoryResource::collection(CertificateCategory::where('cat_id', 1)->get()),
            'certificates_2' => CertificateCategoryResource::collection(CertificateCategory::where('cat_id', 2)->get()),
            'certificates_3' => CertificateCategoryResource::collection(CertificateCategory::where('cat_id', 3)->get()),


            'duration1'      => $this->duration1,
            'duration2'      => $this->duration2,
            'duration3'      => $this->duration3,

            'background3'  => ($this->image3) ? request()->root() . '/uploads/' . $this->image3->url : NULL,

            'title3'       => $this->dTitle,
            'programs'     => CertificateProductResource::collection(CertificateProduct::get()),

            'background4'  => ($this->image4) ? request()->root() . '/uploads/' . $this->image4->url : NULL,
            'title4'       => $this->cTitle,
            'body4'        => $this->cBody,
        ];
    }
}
