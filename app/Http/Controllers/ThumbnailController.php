<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
 
use \App\Models\Thumbnail;

class ThumbnailController extends Controller
{
    /**
     * Save a thumbnail image
     * 
     * @param image thumbnail - Image file, png or jpg
     * 
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->authorize('create', Thumbnail::class);
        
        //Validate request
        $request->validate([
            //Required Parameters
            'thumbnail' => 'required|image'
        ]);

        $file = $request->file('thumbnail');
        
        $thumbnail = new Thumbnail();
        $thumbnail->url = 'file_temp_name';
        $thumbnail->save();

        $file_name = 'thumbnail_'. $thumbnail->id . '.' . $file->extension();

        Storage::disk('public')->put($file_name, $file->get());

        $thumbnail->url = $file_name;
        $thumbnail->save();
        
        return response()->json(['thumbnail_id' => $thumbnail->id]);
    }

     /**
     * Get a thumbnail image and his url
     * 
     * @param int id - Id of the thumbnail
     * 
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, $id)
    {
        $thumbnail = Thumbnail::findOrFail($id);
        return response()->json($thumbnail);
          
    }
}
