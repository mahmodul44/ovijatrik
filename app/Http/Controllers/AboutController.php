<?php

namespace App\Http\Controllers;

use App\Models\About;
use App\Models\Company;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
class AboutController extends Controller
{
    public function index()
    {
        $data['about'] = About::first();
        return view('admin.pages.about.index', $data);
    }

    public function create(){
        $data['about'] = About::first();
        return view('admin.pages.about.create',$data);
    }

    public function edit($id){
        $data['about'] = About::first();
        return view('admin.pages.about.edit',$data);
    }

    function basicSetting(){
        $data['about'] = About::first();
        return view('admin.pages.about.basic_setting', $data);
    }

    public function basicSettingUpdate(Request $request, $id)
{
 
    try {

        $validate = Validator::make($request->all(), [
            'title'       => 'required',
            'email'       => 'required',
            'mobile'      => 'required',
            'facebook'    => 'required',
            'linkedin'    => 'required',
            'address'     => 'required',
        ]);

        if ($validate->fails()) {
            return response()->json([
                'status' => false,
                'message' => "Validation failed",
                'errors' => $validate->errors()
            ], 400);
        }

        $about = About::find($id);

        if (!$about) {
            return response()->json([
                'status' => false,
                'message' => "About not found"
            ], 404);
        }

        // Save basic fields
        $about->title = $request->title;
        $about->email = $request->email;
        $about->mobile = $request->mobile;
        $about->facebook = $request->facebook;
        $about->linkedin = $request->linkedin;
        $about->address = strip_tags($request->address);

        if ($request->hasFile('logo_dark')) {
            if ($about->logo_dark && file_exists(public_path($about->logo_dark))) {
                unlink(public_path($about->logo_dark));
            }

            $file = $request->file('logo_dark');
            $path = 'uploads/abouts/';
            $filename = 'dark_' . time() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path($path), $filename);

            $about->logo_dark = $path . $filename;
        }

        if ($request->hasFile('logo_light')) {
            if ($about->logo && file_exists(public_path($about->logo))) {
                unlink(public_path($about->logo));
            }

            $file = $request->file('logo_light');
            $path = 'uploads/abouts/';
            $filename = 'light_' . time() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path($path), $filename);

            $about->logo = $path . $filename;
        }


        $about->save();

        return response()->json([
            'status' => true,
            'message' => "Updated successfully",
            'about' => $about
        ], 200);

    } catch (\Throwable $th) {
        return response()->json([
            'status' => false,
            'message' => "Error occurred",
            'error' => $th->getMessage()
        ], 500);
    }
}


    function missionVission(){
        $data['about'] = About::first();
        return view('admin.pages.about.missionvission',$data);
    }

    function missionVissionStore(Request $request,$id){
        try {
            $validate = Validator::make($request->all(), [
                'mission'      => 'required',
                'mission_bn'   => 'required',
                'vision'      => 'required',
                'vision_bn'   => 'required',
            ]);

            if ($validate->fails()) {
                $data['status'] = false;
                $data['message'] = "Validation failed! Please check your inputs...";
                $data['errors'] = $validate->errors();
                return response(json_encode($data, JSON_PRETTY_PRINT), 400)->header('Content-Type', 'application/json');
            }
            if ($request->id) {
                $about  = About::find($request->id);

                if (!$about) {
                    $data['status'] = false;
                    $data['message'] = "Validation failed! Please check your inputs...";
                    $data['about'] = $about;
                    return response(json_encode($data, JSON_PRETTY_PRINT), 404)->header('Content-Type', 'application/json');
                }

                $about->mission    = $request->mission;
                $about->mission_bn = $request->mission_bn;
                $about->vision    = $request->vision;
                $about->vision_bn = $request->vision_bn;
                $about->updated_by = Auth::id();

            } else {
                $about  = new About();
                $about->mission    = $request->mission;
                $about->mission_bn = $request->mission_bn;
                $about->vision    = $request->vision;
                $about->vision_bn = $request->vision_bn;
                $about->created_by = Auth::id();

            }
            if ($about->save()) {
                $data['status'] = true;
                $data['message'] = "Saved successfully.";
                $data['about'] = $about;
                return response(json_encode($data, JSON_PRETTY_PRINT), 200)->header('Content-Type', 'application/json');
            } else {
                $data['status'] = false;
                $data['message'] = "Save failed. Please try again...";
                $data['about'] = $about;
                return response(json_encode($data, JSON_PRETTY_PRINT), 500)->header('Content-Type', 'application/json');
            }
        } catch (\Throwable $th) {
            $data['status'] = false;
            $data['message'] = "Something went wrong! Please try again...";
            $data['errors'] = $th;
            return response(json_encode($data, JSON_PRETTY_PRINT), 500)->header('Content-Type', 'application/json');
        }
    }

    public function store(Request $request)
    {

        try {
            $validate = Validator::make($request->all(), [
                'about'        => 'required',
                'message'      => 'required',
                'message_img'  => 'nullable|image|mimes:jpg,png,jpeg|max:1024',
            ]);

            if ($validate->fails()) {
                $data['status'] = false;
                $data['message'] = "Validation failed! Please check your inputs...";
                $data['errors'] = $validate->errors();
                return response(json_encode($data, JSON_PRETTY_PRINT), 400)->header('Content-Type', 'application/json');
            }
            if ($request->id) {
                $about  = About::find($request->id);

                if (!$about) {
                    $data['status'] = false;
                    $data['message'] = "Validation failed! Please check your inputs...";
                    $data['about'] = $about;
                    return response(json_encode($data, JSON_PRETTY_PRINT), 404)->header('Content-Type', 'application/json');
                }

                $about->about = $request->about;
                $about->about_bn = $request->about_bn;
                $about->message = $request->message;
                $about->message_bn = $request->message_bn;
                $about->updated_by = Auth::id();
                if ($request->hasFile('message_img')) {
                    if (!empty($about->message_img) && file_exists(public_path($about->message_img))) {
                      unlink(public_path($about->message_img));
                    }

                $image = $request->file('message_img');
                $image_name = "founderImg-" . date("Ymd") . '-' . rand(11, 99);
                $ext = strtolower($image->getClientOriginalExtension());
                $image_full_name = $image_name . "." . $ext;
                $upload_path = 'uploads/abouts/';
                $image->move(public_path($upload_path), $image_full_name);
                $about->message_img = $image_full_name;
              }
               
            } else {
                $about  = new About();
                $about->about = $request->about;
                $about->about_bn = $request->about_bn;
                $about->message = $request->message;
                $about->message_bn = $request->message_bn;
                $about->created_by = Auth::id();

                if ($request->hasFile('message_img')) {
                    if (!empty($about->message_img) && file_exists(public_path($about->message_img))) {
                      unlink(public_path($about->message_img));
                    }

                $image = $request->file('message_img');
                $image_name = "founderImg-" . date("Ymd") . '-' . rand(11, 99);
                $ext = strtolower($image->getClientOriginalExtension());
                $image_full_name = $image_name . "." . $ext;
                $upload_path = 'uploads/abouts/';
                $image->move(public_path($upload_path), $image_full_name);
                $about->message_img = $image_full_name;
              }
            }
            if ($about->save()) {
                $data['status'] = true;
                $data['message'] = "About information saved successfully.";
                $data['about'] = $about;
                return response(json_encode($data, JSON_PRETTY_PRINT), 200)->header('Content-Type', 'application/json');
            } else {
                $data['status'] = false;
                $data['message'] = "About information save failed. Please try again...";
                $data['about'] = $about;
                return response(json_encode($data, JSON_PRETTY_PRINT), 500)->header('Content-Type', 'application/json');
            }
        } catch (\Throwable $th) {
            $data['status'] = false;
            $data['message'] = "Something went wrong! Please try again...";
            $data['errors'] = $th;
            return response(json_encode($data, JSON_PRETTY_PRINT), 500)->header('Content-Type', 'application/json');
        }
    }

}
