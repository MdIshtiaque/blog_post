<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Comment;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Brian2694\Toastr\Facades\Toastr;
use App\Http\Requests\CommentStoreRequest;

class CommentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $comments = Comment::query()
        ->with('post')
        ->latest('id')
        ->select(
            'id',
            'post_id',
            'comment_des',
        )
        ->get();

        return view('backend.pages.comment.index', compact('comments'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $posts = Post::select(['id', 'title'])->get();

        return view('backend.pages.comment.create', compact('posts'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CommentStoreRequest $request)
    {
        $comment = Comment::create([
            'post_id' => $request->post_id,
            'comment_des' => $request->comment_des
        ]);


        Toastr::success('New Comment Added Successfully');

        return redirect()->route('comment.index');

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
        $posts = Post::get(['id', 'title']);
        $comments = Comment::whereId($id)->first();

        return view('backend.pages.comment.edit', compact('comments', 'posts'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $comments = Comment::whereId($id)->first();
        $comments->update([
            'post_id' => $request->post_id,
            'comment_des' => $request->comment_des
        ]);


        Toastr::success('Comment Updated Successfully');

        return redirect()->route('comment.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $comments = Comment::whereId($id)->first()->delete();

        Toastr::success('Comment Deleted Successfully');

        return redirect()->route('comment.index');
    }
}
