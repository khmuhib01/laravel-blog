<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\CategoryFormRequest;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CategoryController extends Controller
{
    public function index () {
        $categories = Category::all();
        return view('admin.category.category', compact('categories'));
    }

    public function create() {
        return view('admin.category.category-create');
    }

    public function edit($id) {
        $category = Category::find($id);
        return view('admin.category.category-edit', compact('category'));
    }

    public function store(CategoryFormRequest $request) {
        $data = $request->validated();

        $category = new Category;
        $category->name = $data['name'];
        $category->slug = $data['slug'];
        $category->description = $data['description'];

        if($request->hasfile('image')){
            $file = $request->file('image');
            $extention = $file->getClientOriginalExtension();
            $filename = time().rand(1000, 9999).'.'.$extention;
            $file->move('uploads/category', $filename);
            $category->image = $filename;
        }

        $category->meta_title = $data['meta_title'];
        $category->meta_description = $data['meta_description'];
        $category->meta_keyword = $data['meta_keyword'];

        $category->navbar_status = $request->navbar_status == true ? '1':'0';
        $category->status = $request->status == true ? '1':'0';

        $category->created_by = Auth::user()->id;
        $category->save();

        //return dd($category);

        return redirect()->route('category')->with('message', 'Category Inserted Successfully');



    }

    public function update(CategoryFormRequest $request, $id) {


        $data = $request->validated();


        $category = Category::find($id);
        $category->name = $data['name'];
        $category->slug = $data['slug'];
        $category->description = $data['description'];

        if($request->hasfile('image')){
            $file = $request->file('image');
            $extention = $file->getClientOriginalExtension();
            $filename = time().rand(1000, 9999).'.'.$extention;
            $file->move('uploads/category', $filename);
            $category->image = $filename;
        }

        $category->meta_title = $data['meta_title'];
        $category->meta_description = $data['meta_description'];
        $category->meta_keyword = $data['meta_keyword'];

        $category->navbar_status = $request->navbar_status == true ? '1':'0';
        $category->status = $request->status == true ? '1':'0';

        $category->created_by = Auth::user()->id;
        dd($category);
        $category->update();

        return dd($category);

        return redirect()->route('category')->with('message', 'Category Updated Successfully');
    }
}
