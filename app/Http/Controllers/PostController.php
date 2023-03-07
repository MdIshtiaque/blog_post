<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Brian2694\Toastr\Facades\Toastr;
use Intervention\Image\Facades\Image;
use App\Http\Requests\PostStoreRequest;
use App\Http\Requests\PostUpdateRequest;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $posts = Post::query()
        ->with('category')
        ->latest('id')
        ->select(
            'id',
            'category_id',
            'creator_name',
            'title',
            'description',
            'image',
            'created_at'
        )
        ->get();

        return view('backend.pages.post.index', compact('posts'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = Category::select(['id', 'name'])->get();

        return view('backend.pages.post.create', compact('categories'));

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(PostStoreRequest $request)
    {
        $post = Post::create([
            'category_id' => $request->category_id,
            'creator_name' => $request->creator_name,
            'title' => $request->title,
            'description' => $request->description
        ]);

        $this->image_upload($request, $post->id);

        Toastr::success('New Post Added Successfully');

        return redirect()->route('post.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $categories = Category::get(['id', 'name']);
        $posts = Post::whereId($id)->first();

        return view('backend.pages.post.edit', compact('posts', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(PostUpdateRequest $request, $id)
    {

        $posts = Post::whereId($id)->first();
        $posts->update([
            'category_id' => $request->category_id,
            'creator_name' => $request->creator_name,
            'title' => $request->title,
            'description' => $request->description
        ]);

        $this->image_upload($request, $posts->id);

        Toastr::success('Post Updated Successfully');

        return redirect()->route('post.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $posts = Post::whereId($id)->first();

        if ($posts->image != 'default_image.jpg') {
            if ($posts->image) {
                $photo_location = 'uploads/post/' . $posts->image;
                unlink($photo_location);
            }
        }

        $posts->delete();

        Toastr::success('Post Deleted Successfully');

        return redirect()->route('post.index');
    }

    public function image_upload($request, $item_id)
    {
        $post = Post::findorFail($item_id);

        if($request->hasFile('image'))
        {
            if($post->image != 'default_image.jpg')
            {
                //delete image
                $photo_location = 'public/uploads/post/';
                $old_photo_location = $photo_location .
                $post->image;
                unlink(base_path($old_photo_location));
            }
            $photo_location = 'public/uploads/post/';
            $uploaded_photo = $request->file('image');
            $new_photo_name = $post->id . '.' .
            $uploaded_photo->getClientOriginalExtension();
            $new_photo_location = $photo_location . $new_photo_name;
            Image::make($uploaded_photo)->resize(300,300)->save(base_path($new_photo_location),40);
            $check = $post->update([
                'image' => $new_photo_name
            ]);
        }
    }
}
