<?php

namespace App\Http\Controllers;

use App\Models\SubCategory;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\File;
use Auth;
use Storage;

class SubCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $subCategories = SubCategory::all();
        $categories = Category::all();
        return view('pages.subCategories.index', compact('subCategories','categories'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $subCategory = new SubCategory();
        $subCategory->category_id = $request->input('category');
        $subCategory->name = $request->input('sub_category_name');
        $subCategory->description = $request->input('sub_category_description');

        if($request->hasFile('image')) {
            $file = $request->file('image');
            $fileName = time().'.'.$file->getClientOriginalExtension();
            $path = Storage::disk('public_uploads')->putFileAs('subCategory', $file, $fileName);

            $subCategory->image = 'uploads/' . $path;
         }
         $subCategory->slug = Str::slug($request->input('sub_category_name'));
         $subCategory->status = $request->input('status');
         $subCategory->save();

         return response()->json([
            'status' => 200,
            'message' => "Sub Category created successfully"
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\SubCategory  $subCategory
     * @return \Illuminate\Http\Response
     */
    public function get($id)
    {
        $subCategories = SubCategory::where('category_id', $id)->get();

       // $subCategories = $category->subCategories;

        return response()->json([
            'status' => 200,
            'subCategories' => $subCategories
        ]);

    }


    /**
     * Display the specified resource.
     *
     * @param  \App\Models\SubCategory  $subCategory
     * @return \Illuminate\Http\Response
     */
    public function show(SubCategory $subCategory)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\SubCategory  $subCategory
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $sub_category = SubCategory::find($id);
        $categories = Category::all();
        return response()->json([
            'status' => 200,
            'sub_category' => $sub_category,
            'categories' => $categories
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\SubCategory  $subCategory
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $subCategory = SubCategory::find($id);
        $subCategory->category_id = $request->input('category');
        $subCategory->name = $request->input('sub_category_name');
        $subCategory->description = $request->input('sub_category_description');

        if($request->hasFile('image')) {
            $file = $request->file('image');
            $fileName = time().'.'.$file->getClientOriginalExtension();
            $path = Storage::disk('public_uploads')->putFileAs('subCategory', $file, $fileName);

            if ($subCategory->image) {
                File::delete($path);
            }
            $subCategory->image = 'uploads/' . $path;
         }
        $subCategory->slug = Str::slug($request->input('sub_category_name'));
        $subCategory->status = $request->input('status');
        $subCategory->save();

        return response()->json([
            'status' => 200,
            'message' => "Sub Category updated successfully"
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\SubCategory  $subCategory
     * @return \Illuminate\Http\Response
     */
    public function delete($id)
    {
        $subCategory = SubCategory::find($id);
        $subCategory->delete();

        return response()->json([
            'status' => 200,
            'message' => "Sub Category deleted successfully"
        ]);
    }
}
