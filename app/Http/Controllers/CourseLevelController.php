<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\CourseLevel;
use App\Models\SubCategory;
use Illuminate\Http\Request;

class CourseLevelController extends Controller
{
    public function index()
    {
        $course_levels = CourseLevel::with('category', 'sub_category')->get();
        $categories = Category::all();
        $sub_categories = SubCategory::all();

        // get the default inner page
        return view('pages.courseLevels.index', compact('course_levels','categories', 'sub_categories'));
    }

    public function store(Request $request)
    {
            $category = new CourseLevel();
            $category->category_id = $request->input('category');
            $category->sub_category_id = $request->input('sub_category');
            $category->name = $request->input('name');
            $category->save();

             return response()->json([
                'status' => 200,
                'message' => "Level created successfully"
            ]);
    }

    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        $course_level = CourseLevel::find($id);
        $categories = Category::all();
        $sub_categories = SubCategory::all();

        return response()->json([
            'status' => 200,
            'levels' => $course_level,
            'sub_categories' => $sub_categories,
            'categories' => $categories
        ]);
    }

    public function update(Request $request, $id)
    {
        $course_level = CourseLevel::find($id);
        $course_level->category_id = $request->input('category');
        $course_level->sub_category_id = $request->input('sub_category');
        $course_level->name = $request->input('name');
        $course_level->save();

        return response()->json([
            'status' => 200,
            'message' => "Level updated successfully"
        ]);
    }

    public function delete($id)
    {
        $course_level = CourseLevel::find($id);
        $course_level->delete();

        return response()->json([
            'status' => 200,
            'message' => "Level deleted successfully"
        ]);
    }
}
