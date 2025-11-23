<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\SubCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;
use Illuminate\Support\Facades\File;

class SubCategoryController extends Controller
{
    public function index()
    {
        $data['subcategories'] = SubCategory::with('category')->orderBy('sub_cat_id', 'desc')->get();
        return view('admin.pages.subcategory.index',  $data);
    }

    public function create()
    {
        $data = array();
        $data['menu'] = "SubCategory";
        $data['submenu'] = "Create-SubCategory";
        $data['categoris'] = Category::where('status',1)->get();
        return view('admin.pages.subcategory.create', $data);
    }

    public function store(Request $request)
    {
        try {
            $validate = Validator::make($request->all(), [
                'sub_cat_name_bn'  => 'required|max:200',
                'sub_cat_name'     => 'required|max:200',
                'category_id'      => 'required',
            ]);

            if ($validate->fails()) {
                $data['status'] = false;
                $data['message'] = "Validation failed! Please check your inputs...";
                $data['errors'] = $validate->errors();
                return response(json_encode($data, JSON_PRETTY_PRINT), 400)->header('Content-Type', 'application/json');
            }
          
            $subcategory = new SubCategory();
            $subcategory->category_id       = $request->category_id;
            $subcategory->sub_cat_name      = $request->sub_cat_name;
            $subcategory->sub_cat_name_bn   = $request->sub_cat_name_bn;
            $subcategory->created_by        = Auth::id();
            $subcategory->status            = $request->status ? $request->status : 1;
            
            if ($subcategory->save()) {
                $data['status'] = true;
                $data['message'] = "Saved successfully.";
                $data['subcategory'] = $subcategory;
                return response(json_encode($data, JSON_PRETTY_PRINT), 200)->header('Content-Type', 'application/json');
            } else {
                $data['status'] = false;
                $data['message'] = "Save failed! Please try again...";
                $data['subcategory'] = $subcategory;
                return response(json_encode($data, JSON_PRETTY_PRINT), 500)->header('Content-Type', 'application/json');
            }
        } catch (\Throwable $th) {
            $data['status'] = false;
            $data['message'] = "Something went wrong! Please try again...";
            $data['errors'] = $th;
            return response(json_encode($data, JSON_PRETTY_PRINT), 500)->header('Content-Type', 'application/json');
        }
    }

    public function edit($id)
    {
        $data['categoris'] = Category::where('status',1)->get();
        $data['subcategories'] = SubCategory::findOrFail($id); 
        return view('admin.pages.subcategory.edit', $data);
    }

    public function update(Request $request, $id)
    {
    try {
        $validate = Validator::make($request->all(), [
            'sub_cat_name_bn'  => 'required|max:200',
            'sub_cat_name'     => 'required|max:200',
            'category_id'      => 'required',
        ]);

        if ($validate->fails()) {
            return response()->json([
                'status'  => false,
                'message' => "Validation failed! Please check your inputs...",
                'errors'  => $validate->errors()
            ], 400);
        }

        $subcategory = SubCategory::findOrFail($id);
        
        $subcategory->category_id       = $request->category_id;
        $subcategory->sub_cat_name      = $request->sub_cat_name;
        $subcategory->sub_cat_name_bn   = $request->sub_cat_name_bn;
        $subcategory->status            = $request->status ? $request->status : 1;
        $subcategory->updated_by         = Auth::id();

        if ($subcategory->save()) {
            return response()->json([
                'status'  => true,
                'message' => "Updated successfully.",
                'subcategory' => $subcategory
            ], 200);
        } else {
            return response()->json([
                'status'  => false,
                'message' => "Update failed! Please try again..."
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

    function destroy($id){
       $subcategory = SubCategory::findOrFail($id);
       $subcategory->delete();
       return response()->json(['success' => true, 'message' => 'Deleted successfully']);
    }

}
