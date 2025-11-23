<?php

namespace App\Http\Controllers;
use App\Models\About;
use App\Models\Gallery;
use App\Models\Category;
use App\Models\Project;
use Illuminate\Http\Request;

class FrontendController extends Controller
{
    public function about(){
        return response()->json(About::first());
    }

     public function gallery(){
        return response()->json(Gallery::all());
    }

    public function categories()
    {
        return response()->json(Category::all());
    }

    public function projects()
    {
        return response()->json(Project::where('status',1)->where('project_id','!=',10000001)->get());
    }

    public function projectDetails($id)
    {
        return Project::findOrFail($id);
    }

    public function completeprojects(){
        return response()->json(Project::where('status',2)->get());
    }

    public function byCategory($id)
    {
        return response()->json(
            Gallery::where('category_id', $id)->get()
        );
    }

    public function membership(){
        return response()->json(Gallery::all());
    }

    public function projectActive()
    {
        return Project::leftJoin('debit_credit_ledger', 'projects.project_id', '=', 'debit_credit_ledger.project_id')
        ->select('projects.*', 'debit_credit_ledger.*') 
        ->get();
    }

}
