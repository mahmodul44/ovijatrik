<?php

namespace App\Http\Controllers;
use App\Models\Gallery;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class GalleryController extends Controller
{
    public function index()
    {
        $query = Gallery::query();
        $data['galleries'] = Gallery::with('category')->orderBy('id', 'desc')->get();
        return view('admin.pages.gallery.index',  $data);
    }

    public function create()
    {
        $data = array();
        $data['menu'] = "Gallery";
        $data['submenu'] = "Create-Gallery";
        $data['categories'] = Category::where('status',1)->get();
        return view('admin.pages.gallery.create', $data);
    }

    public function store(Request $request)
    {
      //  dd($request->all());
        try {
            $validate = Validator::make($request->all(), [
                'title' => 'required|max:190',
                'image' => 'required|image|mimes:jpg,png,jpeg',
            ]);

            if ($validate->fails()) {
                $data['status'] = false;
                $data['message'] = "Validation failed! Please check your inputs...";
                $data['errors'] = $validate->errors();
                return response(json_encode($data, JSON_PRETTY_PRINT), 400)->header('Content-Type', 'application/json');
            }

            $gallery = new Gallery();
            $gallery->caption = $request->title;
            $gallery->category_id = '102';
            $gallery->created_by = Auth::id();
            $gallery->status = $request->status ? $request->status : false;

            $image = $request->file('image');
            if($image){
                // $image_name = Str::slug($request->caption, '-');
            $image_name = "gallery-" . date("Ymd") . '-' . rand(111, 999);
            $ext = strtolower($image->getClientOriginalExtension());
            $image_full_name = $image_name . "." . $ext;
            $upload_path = 'uploads/galleries/';
            $image_url = $upload_path . $image_full_name;
            $success = $image->move($upload_path, $image_full_name);
            if ($success) {
                $gallery->image = $image_url;
             }
            }
            
            if ($gallery->save()) {
                $data['status'] = true;
                $data['message'] = "Gallery saved successfully.";
                $data['gallery'] = $gallery;
                return response(json_encode($data, JSON_PRETTY_PRINT), 200)->header('Content-Type', 'application/json');
            } else {
                $data['status'] = false;
                $data['message'] = "Gallery save failed! Please try again...";
                $data['gallery'] = $gallery;
                return response(json_encode($data, JSON_PRETTY_PRINT), 500)->header('Content-Type', 'application/json');
            }
        } catch (\Throwable $th) {
            $data['status'] = false;
            $data['message'] = "Something went wrong! Please try again...";
            $data['errors'] = $th;
            return response(json_encode($data, JSON_PRETTY_PRINT), 500)->header('Content-Type', 'application/json');
        }
    }

    function edit($id){
        $data = array();
        $data['menu'] = "Gallery";
        $data['submenu'] = "View-Gallery";
        $data['categories'] = Category::where('status',1)->get();
        $data['galleries'] = Gallery::findOrFail($id); 
        return view('admin.pages.gallery.edit', $data);
    }

    public function update(Request $request, $id)
    {
    try {
        $validate = Validator::make($request->all(), [
            'title'       => 'required|max:100',
            'image'       => 'nullable|image|mimes:jpg,png,jpeg,pdf',
        ]);

        if ($validate->fails()) {
            return response()->json([
                'status'  => false,
                'message' => "Validation failed! Please check your inputs...",
                'errors'  => $validate->errors()
            ], 400);
        }

        $galleries = Gallery::findOrFail($id);
        $galleries->caption          = $request->title;
        $galleries->category_id      = $request->category_id;
        $galleries->updated_by       = Auth::id();
        $galleries->status           = $request->status ?? 1;

        if ($request->hasFile('image')) {
            // Optional: delete old image file
            if (!empty($galleries->image) && file_exists(public_path($galleries->image))) {
                unlink(public_path($galleries->image));
            }

            $image = $request->file('image');
            $image_name = "project-" . date("Ymd") . '-' . rand(111, 999);
            $ext = strtolower($image->getClientOriginalExtension());
            $image_full_name = $image_name . "." . $ext;
            $upload_path = 'uploads/galleries/';
            $image->move(public_path($upload_path), $image_full_name);
            $galleries->image = $upload_path . $image_full_name;
        }

        if ($galleries->save()) {
            return response()->json([
                'status'  => true,
                'message' => "Project updated successfully.",
                'project' => $galleries
            ], 200);
        } else {
            return response()->json([
                'status'  => false,
                'message' => "Project update failed! Please try again..."
            ], 500);
        }
    } catch (\Throwable $th) {
        return response()->json([
            'status'  => false,
            'message' => "Something went wrong! Please try again...",
            'errors'  => $th->getMessage()
        ], 500);
     }
    }

    public function destroy($id)
   {
    $gallery = Gallery::findOrFail($id);
    $gallery->delete();

    if (request()->ajax()) {
        return response()->json([
            'success' => true,
            'message' => 'Gallery deleted successfully.'
        ]);
    }

    return redirect()->route('gallery.index')->with('success', 'Gallery deleted successfully.');
   }


}
