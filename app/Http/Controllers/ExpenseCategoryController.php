<?php

namespace App\Http\Controllers;

use App\Models\ExpenseCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;

class ExpenseCategoryController extends Controller
{
    function index()
    {
        $data['categories'] = ExpenseCategory::orderBy('expense_cat_id', 'desc')->get();
        return view('admin.pages.expensecategory.index',  $data);
    }

    function create()
    {
        $data['categoris'] = ExpenseCategory::where('status',1)->get();
        return view('admin.pages.expensecategory.create', $data);
    }

    function store(Request $request)
    {
        try {
            $validate = Validator::make($request->all(), [
                'category_name'        => 'required|max:200',
                'category_name_bn'     => 'required|max:200',
            ]);

            if ($validate->fails()) {
                $data['status'] = false;
                $data['message'] = "Validation failed! Please check your inputs...";
                $data['errors'] = $validate->errors();
                return response(json_encode($data, JSON_PRETTY_PRINT), 400)->header('Content-Type', 'application/json');
            }
          
            $category = new ExpenseCategory();
            $category->expense_cat_name        = $request->category_name;
            $category->expense_cat_name_bn     = $request->category_name_bn;
            $category->expense_cat_added_by    = Auth::id();
            $category->status                  = $request->status ? $request->status : 1;
            
            if ($category->save()) {
                $data['status'] = true;
                $data['message'] = "Saved successful.";
                $data['category'] = $category;
                return response(json_encode($data, JSON_PRETTY_PRINT), 200)->header('Content-Type', 'application/json');
            } else {
                $data['status'] = false;
                $data['message'] = "Save failed! Please try again...";
                $data['category'] = $category;
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
        $data['category'] = ExpenseCategory::findOrFail($id); 
        return view('admin.pages.expensecategory.edit', $data);
    }

    function update(Request $request, $id)
    {
    try {
        $validate = Validator::make($request->all(), [
            'category_name'       => 'required|max:100',
            'category_name_bn'     => 'nullable|min:3|max:250',
        ]);

        if ($validate->fails()) {
            return response()->json([
                'status'  => false,
                'message' => "Validation failed! Please check your inputs...",
                'errors'  => $validate->errors()
            ], 400);
        }

            $category = ExpenseCategory::findOrFail($id);
            $category->expense_cat_name        = $request->category_name;
            $category->expense_cat_name_bn     = $request->category_name_bn;
            $category->expense_cat_edited_by   = Auth::id();
            $category->status                  = $request->status ? $request->status : 1;

        if ($category->save()) {
            return response()->json([
                'status'  => true,
                'message' => "Updated successful.",
                'category' => $category
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
       $category = ExpenseCategory::findOrFail($id);
       $category->delete();

       return response()->json(['success' => true, 'message' => 'Deleted successful']);
    }
}
