<?php

namespace App\Models;

use DB;
use App\Models\Setting;
use App\Mail\MessageMailable;
use Illuminate\Support\Facades\Mail;
use Illuminate\Database\Eloquent\Model;

class Inbox extends Model
{
    protected $guarded = [];


    // fetch Data
    public static function fetchData($value='')
    {
        // this way will fire up speed of the query
        $obj = self::query();

          // search for multiple columns..
          if(isset($value['search']) && $value['search']) {
            $obj->where(function($q) use ($value) {
                $q->where('name', 'like', '%'.$value['search'].'%');
                $q->orWhere('email', 'like', '%'.$value['search'].'%');
                $q->orWhere('id', $value['search']);
              });
          }


          // status
          if(isset($value['status']) && $value['status']) {
              if($value['status'] == 'active')
                  $obj->where(['status' => true, 'trash' => false]);
              else if ($value['status'] == 'inactive')
                  $obj->where(['status' => false, 'trash' => false]);
              else if ($value['status'] == 'trash')
                  $obj->where('trash', true);
          }

          // order By..
          if(isset($value['order']) && $value['order']) {
            if($value['order_by'] == 'title')
              $obj->orderBy('title', $value['order']);
            else if ($value['order_by'] == 'created_at')
              $obj->orderBy('created_at', $value['order']);
            else
              $obj->orderBy('id', $value['order']);
          } else {
            $obj->orderBy('id', 'DESC');
          }

          // feel free to add any query filter as much as you want...

        $obj = $obj->paginate($value['paginate'] ?? 10);
        return $obj;
    }



    // 
    public static function createOrUpdate($value)
    {
        try {
            
            DB::beginTransaction();

              // Row
              $row              = (isset($id)) ? self::findOrFail($id) : new self;
              $row->name        = $value['name'] ?? NULL;
              $row->email       = $value['email'] ?? NULL;
              $row->message     = $value['message'] ?? NULL;
              $row->save();


                // Send Email
                $to     = Setting::where('title','to_email')->first();
                $email  = ($to) ? $to->body : NULL;
                $bcc    = Setting::where('title', 'bcc_emails')->first();
                $emails = ($bcc) ? explode(',', $bcc->body) : NULL;
                try {
                    Mail::to($email)
                          ->bcc($emails)
                          ->send(new MessageMailable($row));
                } catch (\Exception $e) { }



            DB::commit();

            return true;
        } catch (\Exception $e) {
            DB::rollback();
            return $e->getMessage();
        }
    }
}
