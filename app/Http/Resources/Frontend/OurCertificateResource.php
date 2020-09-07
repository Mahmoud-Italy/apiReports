<?php

namespace App\Http\Resources\Frontend;

use App\Models\CertificateCategory;
use App\Models\CertificateProduct;
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
        foreach (CertificateCategory::where('cat_id', 1)->get() as $cat1) {
            $certificates_1[] = [
                'title'   => $cat1->title,
                'image'   => $cat1->image() ? request()->root(). '/uploads/' . $cat1->image()->url : null,
                'pdf'     => $cat1->pdf() ? request()->root(). '/uploads/' . $cat1->pdf()->url : null,
            ];
        }
        
        foreach (CertificateCategory::where('cat_id', 2)->get() as $cat2) {
            $certificates_2[] = [
                'title'   => $cat2->title,
                'image'   => $cat2->image() ? request()->root(). '/uploads/' . $cat2->image()->url : null,
                'pdf'     => $cat2->pdf() ? request()->root(). '/uploads/' . $cat2->pdf()->url : null,
            ];
        }

        foreach (CertificateCategory::where('cat_id', 3)->get() as $cat3) {
            $certificates_3[] = [
                'title'   => $cat3->title,
                'image'   => $cat3->image() ? request()->root(). '/uploads/' . $cat3->image()->url : null,
                'pdf'     => $cat3->pdf() ? request()->root(). '/uploads/' . $cat3->pdf()->url : null,
            ];
        }

        foreach (CertificateProduct::where(['status' => true, 'trash' => false])
                            ->orderBy('sort', 'DESC')
                            ->get() as $pro) {
            $programs[] = [
                'id'        => $pro->id,
                'image'     => $pro->image() ? request()->root(). '/uploads/' . $cat3->image()->url : null,
                'title'     => $pro->title,
                'subTitle'  => $pro->subtitle,
                'slug'      => $pro->slug,
                'shortBody' => $pro->short_body
            ];
        }

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

            'certificates_1' => $certificates_1,
            'certificates_2' => $certificates_2,
            'certificates_3' => $certificates_3,


            'duration'      => $this->duration,

            'background3'  => ($this->image3) ? request()->root() . '/uploads/' . $this->image3->url : NULL,
            'title3'       => $this->dTitle,
            'programs'     => $programs,

            'background4'  => ($this->image4) ? request()->root() . '/uploads/' . $this->image4->url : NULL,
            'title4'       => $this->cTitle,
            'body4'        => $this->cBody,
        ];
    }
}
