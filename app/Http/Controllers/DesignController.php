<?php

namespace App\Http\Controllers;

use Image;
use App\Models\User;
use App\Models\Design;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Filters\DesignFilters;
use Illuminate\Support\Facades\File;

class DesignController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(User $user, DesignFilters $filters)
    {
        $this->authorize('index', [Design::class, $user]);

        if(admin()) {
            $designs = Design::withTrashed()->where('user_id', $user->id);
        } else {
            $designs = Design::where('user_id', auth()->id());
        }
        $categories = $designs->get()
                            ->map(function($design) {
                                return $design->category;
                            })->unique('id');
        $designs = $designs->latest()->filter($filters)->paginate(12);

        return view('designs.index', compact('designs', 'categories'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($categorySlug, $designId = null)
    {
        $design = Design::find($designId);
        if($designId !== null && !$design->ownedByUser()) {
            abort(403, 'Unauthorized action.');
        }
        
        $category = Category::where('slug_name', $categorySlug)->firstOrFail();
        if(auth()->check()) {
            return view('designs.create', [
                        'category' => $category, 
                        'design' => $design, 
                        'existingDesigns'=> Design::fromCategory(auth()->id(), $category->id)]);
        }
        return view('designs.create', compact('category', 'design'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store()
    {
        $design = new Design();
        $category = Category::findOrFail(request()->category_id);
        $filename = $design->makeImage($category);

        if(auth()->check()){
            $design->views = request()->views;
            $design->category_id = $category->id;
            $design->comment = request()->comment;
            $design->save();
            session(['design' => $design->id]);
        } else {
            session([
                'design' => $filename, 
                'fpd-views' => request()->views, 
                'design_comment' => request()->comment
            ]);
        }
        session(['category_id' => request()->category_id]);

        return response()->json([
            'message' => 'Image successfully generated',
            'category_slug_name' => $category->slug_name
        ],200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Design $design)
    {
        $this->authorize('delete', $design);
        $design->delete();
    }
}
