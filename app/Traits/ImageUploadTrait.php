<?php

namespace App\Traits;
use Image;

trait ImageUploadTrait
{
    public function imageUpload($request, $imageName)
    {
        if ( ! $request->hasFile($imageName)) {
            return false;
        }
        $avatar = $request->file($imageName);
        $filename = time(). '.'.$avatar->getClientOriginalExtension();
        Image::make($avatar)->resize(100,100)->save(public_path('uploads/'.$filename));
        $file_path = $filename;
        return $file_path;
    }
}