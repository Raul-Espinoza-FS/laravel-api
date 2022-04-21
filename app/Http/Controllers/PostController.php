<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use \App\Models\Post;

class PostController extends Controller
{
    /**
     * List all posts
     * 
     * @param string title_search - search by title
     * @param int many - number of post per page
     * @param string sort_by - column to sort of
     * @param string direction - direction of the sorting - desc,asc
     * 
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        //Validate request
        $request->validate([
            'title_search' => 'nullable|string',
            'many' => 'nullable|integer',
            'sort_by' => 'nullable|string',
            'direction' => 'nullable|in:asc,desc',
            'page' => 'nullable|integer',
        ]);

        $posts = Post::with('thumbnail')->select('*');

        if (isset($request->title_search)) {
            $posts->where('title', 'like', '%' . $request->title . '%');
        }
        
        $request->many = $request->many ? $request->many : 10;
        $request->sort_by = $request->sort_by ? $request->sort_by : 'id';
        $request->direction = $request->direction ? $request->direction : 'desc';

        $posts = $posts->orderBy($request->sort_by, $request->direction)
                    ->paginate($request->many);

        //Append the query parameters to the links of pagination.
        $posts->appends(request()->query())->links();

        return response()->json($posts);
    }

    /**
     * Save a post
     * 
     * @param string title - Title of the post
     * @param string content - Content of the post
     * @param string tags - Tags fo the post, separated by ","
     * @param int thumbnail_id - Id of the image associated to the post
     * 
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->authorize('create', Post::class);
        
        //Validate request
        $request->validate([
            //Required Parameters
            'title' => 'required|string',
            'content' => 'required|string',
            'tags' => 'required|string',
            'thumbnail_id' => 'required|integer|exists:thumbnails,id',
        ]);

        $new_post = new Post();
        $new_post->title = $request->title;
        $new_post->content = $request->content;
        $new_post->tags = $request->tags;
        $new_post->thumbnail_id = $request->thumbnail_id;
        $new_post->user_id = $request->user()->id;
        $new_post->save();
        
        return response()->json(['post_id' => $new_post->id]);
    }

    /**
     * Get a Post
     * 
     * @param int id - Id of the post to edit
     * 
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, $id)
    {
        $post = Post::with('thumbnail')->findOrFail($id);
        return response()->json($post);
    }

    /**
     * Edit a Post
     * 
     * @param string title - Title of the post
     * @param string content - Content of the post
     * @param string tags - Tags fo the post, separated by ","
     * @param int thumbnail_id - Id of the image associated to the post
     * 
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {

        //Validate request
        $request->validate([
            //Required Parameters
            'title' => 'nullable|string',
            'content' => 'nullable|string',
            'tags' => 'nullable|string',
            'thumbnail_id' => 'nullable|integer|exists:thumbnails,id',
        ]);

        $post = Post::findOrFail($id);

        $this->authorize('edit', $post);

        $post->title = $request->has('title') ? $request->title : $post->title;
        $post->content = $request->has('content') ? $request->content : $post->content;
        $post->tags = $request->has('tags') ? $request->tags : $post->tags;
        $post->thumbnail_id = $request->has('thumbnail_id') ? $request->thumbnail_id : $post->thumbnail_id;
        $post->save();

        return response()->json(['post_id' => $post->id]);
    }

    /**
     * Delete a Post
     * 
     * @param int id - Id of the post to delete
     * 
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {
        $post = Post::findOrFail($id);
        
        $this->authorize('delete', $post);
        
        $post->delete();

        return response()->json(['deleted' => true]);
    }
}
