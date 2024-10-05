<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Intervention\Image\ImageManagerStatic as Image;


class NetworkPayment extends Model
{

    use HasFactory;
    public $table = 'network_payments';

    public  static function AttachMUltiFIleFiles($files, string  $disc, $request)
    {
        $data  = [];
        if (count($files) > 0) {
            foreach ($files as $key => $value) {

                if ($value) {
                    // $name = $value->hashName();
                    $profile_image_File = "/payments_" . date('y_m_d') . '-' . time() . ".png";
                    $path = public_path($disc) . $profile_image_File;
                    // dd($path);
                    Image::make(file_get_contents($value))->save($path);
                    $profile_image = $profile_image_File;
                }
                // I Do This For First Step
                $attachment  = new NetworkPayment();
                // $attachment->attacheable = $agent->id;
                $attachment->attachment = $profile_image;
                $attachment->order_id = $request->order_id;
                // $model->Payments()->save($attachment);
                $attachment->save();
                $data[] = $attachment;
            }
            // (new Payments)->MakeAttachableunderReview($model);
            return $data;
        }
    }
}
