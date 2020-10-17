<?php

namespace App\Models;

use DB;
use App\Models\Imageable;
use Illuminate\Database\Eloquent\Model;

class NewAppLayout extends Model
{
    protected $guarded = [];

    public function image() {
        return $this->morphOne(Imageable::class, 'imageable')->where('is_pdf', 0)->select('url');
    }

    public static function createOrUpdate($id, $value)
    {
        try {
            
            DB::beginTransaction();

              // Row
              $row                  = (isset($id)) ? self::findOrFail($id) : new self;

              $row->bgColor         = $value['bgColor'] ?? NULL;
              $row->bgTitle         = $value['bgTitle'] ?? NULL;
              $row->bgSubTitle      = $value['bgSubTitle'] ?? NULL;
              $row->text1           = $value['text1'] ?? NULL;
              $row->text2           = $value['text2'] ?? NULL;
              $row->text3           = $value['text3'] ?? NULL;

              $row->pdf1            = $value['pdf1'] ?? NULL;
              $row->pdf2            = $value['pdf2'] ?? NULL;
              $row->pdf3            = $value['pdf3'] ?? NULL;
              $row->pdf4            = $value['pdf4'] ?? NULL;
              $row->pdf5            = $value['pdf5'] ?? NULL;
              $row->pdf6            = $value['pdf6'] ?? NULL;

              $row->text4           = $value['text4'] ?? NULL;

              $row->general1_title  = $value['general1_title'] ?? NULL;
              $row->general1_body   = $value['general1_body'] ?? NULL;
              $row->general2_title  = $value['general2_title'] ?? NULL;
              $row->general2_body   = $value['general2_body'] ?? NULL;
              $row->general3_title  = $value['general3_title'] ?? NULL;
              $row->general3_body   = $value['general3_body'] ?? NULL;
              $row->general4_title  = $value['general4_title'] ?? NULL;
              $row->general4_body   = $value['general4_body'] ?? NULL;
              $row->general5_title  = $value['general5_title'] ?? NULL;
              $row->general5_body   = $value['general5_body'] ?? NULL;

              $row->note1           = $value['note1'] ?? NULL;
              $row->note2           = $value['note2'] ?? NULL;

              $row->text5           = $value['text5'] ?? NULL;

              $row->authority_note  = $value['authority_note'] ?? NULL;
              $row->authority_title = $value['authority_title'] ?? NULL;
              $row->authority1      = $value['authority1'] ?? NULL;
              $row->authority2      = $value['authority2'] ?? NULL;
              $row->authority3      = $value['authority3'] ?? NULL;
              $row->authority4      = $value['authority4'] ?? NULL;
              $row->authority5      = $value['authority5'] ?? NULL;
              $row->authority6      = $value['authority6'] ?? NULL;

              $row->head           = $value['head'] ?? NULL;
              $row->last_confirm   = $value['last_confirm'] ?? NULL;
              $row->save();



              // Image
              if(isset($value['image'])) {
                if($value['image']) {
                  $image = Imageable::uploadImage($value['image']);
                  $row->image()->delete();
                  $row->image()->create(['url' => $image]);
                }
              }

            DB::commit();

            return true;
        } catch (\Exception $e) {
            DB::rollback();
            return $e->getMessage();
        }
    }
}
