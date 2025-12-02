<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Project;
use App\Models\Ledger;
use App\Models\ProjectImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;
use Illuminate\Support\Facades\File;
use DB;
class ProjectController extends Controller
{
    public function index()
    {
        $data['projects'] = Project::where('status','!=',2)->where('project_id','!=',10000001)->orderBy('project_id', 'desc')->get();
        return view('admin.pages.project.index',  $data);
    }

    public function create()
    {
        $data = array();
        $data['menu'] = "Project";
        $data['submenu'] = "Create-Project";
        $data['categoris'] = Category::where('status',1)->get();
        return view('admin.pages.project.create', $data);
    }

    public function store(Request $request)
    {
        try {
              $validate = Validator::make($request->all(), [
                'project_title'     => 'required|max:100',
                'project_title_bn'  => 'required|max:100',
                'project_details'   => 'nullable|min:3|max:250',
                'project_details_bn'  => 'nullable|min:3|max:250',
                'category_id'        => 'required',
                'project_start_date' => 'required',
                'image'              => 'required|image|mimes:jpg,png,jpeg,pdf',
            ]);

            if ($validate->fails()) {
                $data['status'] = false;
                $data['message'] = "Validation failed! Please check your inputs...";
                $data['errors'] = $validate->errors();
                return response(json_encode($data, JSON_PRETTY_PRINT), 400)->header('Content-Type', 'application/json');
            }

            $startDate = Carbon::createFromFormat('d/m/Y', $request->project_start_date)->format('Y-m-d');

            $endDate = null;
            if (!empty($request->project_end_date)) {
                $endDate = Carbon::createFromFormat('d/m/Y', $request->project_end_date)->format('Y-m-d');
            }

            $project = new Project();
            $project->category_id     = $request->category_id;
            $project->sub_cat_id      = $request->sub_cat_id;
            $project->project_title   = $request->project_title;
            $project->project_title_bn   = $request->project_title_bn;
            $project->project_code    = $request->project_code;
            $project->target_amount   = $request->target_amount;
            $project->project_details = $request->project_details;
            $project->project_details_bn = $request->project_details_bn;
            $project->project_start_date = $startDate;
            $project->project_end_date   = $endDate;
            $project->created_by         = Auth::id();
            $project->status             = $request->status ? $request->status : 1;

            $image = $request->file('image');
            if($image){
                // $image_name = Str::slug($request->caption, '-');
            $image_name = "project-" . date("Ymd") . '-' . rand(111, 999);
            $ext = strtolower($image->getClientOriginalExtension());
            $image_full_name = $image_name . "." . $ext;
            $upload_path = 'uploads/projects/';
            $image_url = $upload_path . $image_full_name;
            $success = $image->move($upload_path, $image_full_name);
            if ($success) {
                $project->image = $image_url;
             }
            }
            
            if ($project->save()) {
                $data['status'] = true;
                $data['message'] = "Project saved successfully.";
                $data['project'] = $project;
                return response(json_encode($data, JSON_PRETTY_PRINT), 200)->header('Content-Type', 'application/json');
            } else {
                $data['status'] = false;
                $data['message'] = "Project save failed! Please try again...";
                $data['project'] = $project;
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
        $data['menu'] = "Project";
        $data['submenu'] = "Edit-Project";
        $data['categoris'] = Category::where('status',1)->get();
        $data['projects'] = Project::findOrFail($id); 
        return view('admin.pages.project.edit', $data);
    }

    public function update(Request $request, $id)
    {
    try {
        $validate = Validator::make($request->all(), [
            'project_title'       => 'required|max:100',
            'project_title_bn'    => 'required|max:100',
            'project_details'     => 'nullable|min:3|max:250',
            'project_details_bn'  => 'nullable|min:3|max:250',
            'category_id'         => 'required',
            'project_start_date'  => 'required',
            'image'               => 'nullable|image|mimes:jpg,png,jpeg,pdf',
        ]);

        if ($validate->fails()) {
            return response()->json([
                'status'  => false,
                'message' => "Validation failed! Please check your inputs...",
                'errors'  => $validate->errors()
            ], 400);
        }

        $startDate = Carbon::createFromFormat('d/m/Y', $request->project_start_date)->format('Y-m-d');
        $endDate   = !empty($request->project_end_date)
                        ? Carbon::createFromFormat('d/m/Y', $request->project_end_date)->format('Y-m-d')
                        : null;

        $project = Project::findOrFail($id);
        $project->category_id        = $request->category_id;
        $project->sub_cat_id         = $request->sub_cat_id;
        $project->project_title      = $request->project_title;
        $project->project_title_bn      = $request->project_title_bn;
        $project->project_code       = $request->project_code;
        $project->target_amount      = $request->target_amount;
        $project->project_details    = $request->project_details;
        $project->project_details_bn    = $request->project_details_bn;
        $project->project_start_date = $startDate;
        $project->project_end_date   = $endDate;
        $project->updated_by         = Auth::id();
        $project->status             = $request->status ?? 1;

        if ($request->hasFile('image')) {
            if (!empty($project->image) && file_exists(public_path($project->image))) {
                unlink(public_path($project->image));
            }

            $image = $request->file('image');
            $image_name = "project-" . date("Ymd") . '-' . rand(111, 999);
            $ext = strtolower($image->getClientOriginalExtension());
            $image_full_name = $image_name . "." . $ext;
            $upload_path = 'uploads/projects/';
            $image->move(public_path($upload_path), $image_full_name);
            $project->image = $upload_path . $image_full_name;
        }

        if ($project->save()) {
            return response()->json([
                'status'  => true,
                'message' => "Project updated successfully.",
                'project' => $project
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

    function destroy($id){
       $project = Project::findOrFail($id);

        if ($project->image && File::exists(public_path('uploads/projects/' . $project->image))) {
            File::delete(public_path('uploads/projects/' . $project->image));
        }

        $project->delete();

        return response()->json(['success' => true, 'message' => 'Project deleted successfully']);
    }

    function show($id){
        $data['projectPreview'] = Project::with('images','category','subcategory')->findOrFail($id);
        return view('admin.pages.project.preview', $data);
    }

    function projectSearch(Request $request)
    {
        $search = $request->q;

        $results = Project::select('project_id', 'project_code', 'project_title')
            ->where('project_id', '!=', '10000001') 
            ->where(function ($query) use ($search) {
                $query->where('project_title', 'like', "%{$search}%")
                    ->orWhere('project_code', 'like', "%{$search}%");
            })
            ->limit(10)
            ->get();

        $formatted = [];

        foreach ($results as $project) {
            $formatted[] = [
                'id' => $project->project_id,
                'text' => "{$project->project_code} - {$project->project_title}"
            ];
        }

        return response()->json($formatted);
    }


    function imageStore(Request $request, $id)
    {
        $request->validate([
            'image' => 'required|image|mimes:jpg,jpeg,png,gif|max:2048',
            'short_description' => 'nullable|string|max:255',
        ]);

        $filename = time().'_'.$request->file('image')->getClientOriginalName();
        $request->file('image')->move(public_path('uploads/project_gallery'), $filename);
        $path = 'uploads/project_gallery/' . $filename;

        $image = ProjectImage::create([
            'project_id' => $id,
            'image' => $path,
            'short_description' => $request->short_description,
        ]);

        return response()->json([
            'success' => true,
            'image' => $image,
            'message' => 'Image added successfully'
        ]);
    }

    public function ajaxDelete(ProjectImage $image)
  {
    $imagePath = public_path($image->image);

   
    if (file_exists($imagePath)) {
        @unlink($imagePath); 
    }

    $image->delete();

    return response()->json([
        'success' => true,
        'message' => 'Image deleted successfully'
    ]);
}

function complete(Request $request,$id)
{
    $project = Project::findOrFail($id);
    $endDate = Carbon::createFromFormat('d/m/Y', $request->end_date)->format('Y-m-d');
    $project->status = '2';
    $project->project_end_date = $endDate ?? now();

    $project->save();

    return response()->json([
        'success' => true,
        'message' => 'Project marked as complete successfully!',
    ]);
}

function completeProjectlist(){
    $data['projects'] = Project::where('status',2)->orderBy('project_id', 'desc')->get();
    return view('admin.pages.project.completelist',  $data);
}

function reverseProject($id)
{
    $project = Project::findOrFail($id);

    $project->status = '1';
    $project->project_end_date = null;
    $project->save();

    return response()->json([
        'success' => true,
        'message' => 'Project status reversed successfully!',
    ]);
}

public function saveLink(Request $request, $id)
{
    $project = Project::findOrFail($id);

    $project->additional_link = $request->link ?? null; 
    $project->save();

    return response()->json([
        'success' => true,
        'message' => 'Project link saved successfully!'
    ]);
}

public function projectWiseTotal($project_id)
{
    $total = Ledger::where('project_id', $project_id)->sum('ledger_amount'); 

    return response()->json([
        'total' => $total
    ]);
}


}
