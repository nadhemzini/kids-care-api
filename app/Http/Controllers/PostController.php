<?php

namespace App\Http\Controllers;
use App\Http\Requests\PostStoreRequest;
use Illuminate\Support\Facades\Storage;
use App\Models\Post;
use Illuminate\Http\Request;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $post = Post::all();

        return    response()->json(["data"=>$post], 200);

    }
    
    public function show(string $id)
    {
        $post= Post::find($id);
        //    dd($post);
           if(!$post){
            return  response()->json(['message'=>'Post not found'],404);
           }else{
            return  response()->json(["data"=>$post],200);
           }    }
  
    /**
     * Store a newly created resource in storage.
     */
    public function store(PostStoreRequest $request)
    {
        //
        if ($request->has('image')) {
            $image=$request->file('image');
            $name=time(). '.' .$image->getClientOriginalExtension();
            $image->move('images/',$name);
        }
         
          Post::create([
              'title'=>$request->input('title'),
              'image'=>$name,
              'description'=>$request->input('description'),
             
          ]);
          return response()->json(['message'=>'Create Post success'],200);
    }

   
    /**
     * Update the specified resource in storage.
     */
    public function update(request $request, $id)
{
    
    $post = Post::find($id); // Find the post by its ID
    dd($request->has('image'));
        if($request->has('image'))
        {
            $file = $request->file('image');
            $extension = $file->getClientOriginalExtension();
            $filename = time(). '.' . $extension;
            $file->move('images/', $filename);
            $post->image = $filename;
            
        }
        $post ->update([
            'title'=>$request->input('title',$post->title),            
            'description'=>$request->input('description',$post->description),
          ]);
          
    return response()->json(['message' => 'Update Post success'], 200);
}
    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id){
        $post=Post::find($id);
        if (!$post) {
            return  response()->json(['message'=>'post Not Found'],200);
        }
        $post->delete();
        return response()->json(['message'=>'post deleted'],200);
    }
}
