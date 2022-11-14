<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\UserUploadImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Image;

class UserUploadImageController extends Controller
{
    public function gotomyimages()
    {
        $id = Auth::user()->id;
        if (UserUploadImage::where('user_id', $id) == null) {
            session(['data' => 'no data found']);
            Log::info('No Data Found ');
            return view('gotomyimages');
        };
        $images = UserUploadImage::where('user_id', $id)->get();
        return view('gotomyimages', compact('images'));
    }
    public function uploadimages()
    {
        return view('uploadimages');
    }
    public function storeimages(Request $request)
    {

        $this->validate($request, [
            'images' => 'required',
            'images.*' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048']);

        $files = [];
        if ($request->hasFile('images')) {
            foreach ($request->images as $file) {

                $imageName = $file->getClientOriginalName();
                $image = Image::make($file)->resize(200, 200);
                // $path = 'thumbnails/' . $imageName;
                $file->move(public_path() . 'thumbnails/' . $imageName);
                $files[] = $imageName;
            }
        }

        $id = Auth::user()->id;
        foreach ($files as $userimage) {
            $file = new UserUploadImage();
            $file->images = $userimage;
            $file->user_id = $id;
            $file->save();
        }
        Log::info('files has been successfully added ');

        return back()->with('success', ' Your files has been successfully added');
    }

}
