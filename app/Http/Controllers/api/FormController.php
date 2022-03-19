<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Http\Resources\FormResource;
use App\Models\Form;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\File;

class FormController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user=auth()->user();
        $forms=Form::where('user_id',$user->id)->orderBy('created_at','DESC')->paginate(30);
        return FormResource::collection($forms);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data=$request->validate([
            
            'title' => 'required|string|max:1000',
            'image' => 'nullable|string',
           
            'status' => 'required|boolean',
            'description' => 'nullable|string',
            'expire_date' => 'nullable|date|after:tomorrow',
            'questions' => '',
        ]);
        $data['user_id']=auth()->user()->id;
      // Check if image was given and save on local file system
      if (isset($data['image'])) {
        $relativePath  = $this->saveImage($data['image']);
        $data['image'] = $relativePath;
    }
        
        // return $data;
        $response=Form::create([
            'title' => $data['title'],
            'image'=>$data['image'] ,
           'user_id'=>$data['user_id'],
            'status' => $data['status'],
            'description' => $data['description'],
            'expire_date' => $data['expire_date'],
            
        ]);
        return new FormResource($response);

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Form  $form
     * @return \Illuminate\Http\Response
     */
    public function show(Form $form)
    {

        if($form->user_id != auth()->user()->id){
            return abort(403,'Unauthorized action');
        }
        return new FormResource($form);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Form  $form
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Form $form)
    {
        if($form->user_id != auth()->user()->id){
            return abort(403,'Unauthorized action');
        }
        $data=$request->validate([
            'title' => 'required|string|max:1000',
            'image'=>'nullable|string',
           
            'status' => 'required|boolean',
            'description' => 'nullable|string',
            'expire_date' => 'nullable|date|after:tomorrow',
           
        ]);
         // Check if image was given and save on local file system
      if (isset($data['image'])) {
        $relativePath  = $this->saveImage($data['image']);
        $data['image'] = $relativePath;
        // if the is an old image, delete it
        if($form->image){
            $absolutePath=public_path($form->image);
            File::delete($absolutePath);
        }
    }

        $data['user_id']=auth()->user()->id;
        $response=$form->update($data);
   
        return new FormResource($form);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Form  $form
     * @return \Illuminate\Http\Response
     */
    public function destroy(Form $form)
    {
        if($form->user_id != auth()->user()->id){
            return abort(403,'Unauthorized action');
        }
        $form->delete();
        // if the is an old image, delete it
        if($form->image){
            $absolutePath=public_path($form->image);
            File::delete($absolutePath);
        }
        return response('',204);


    }
    private function saveImage($image)
    {
        // Check if image is valid base64 string
        if (preg_match('/^data:image\/(\w+);base64,/', $image, $type)) {
            // Take out the base64 encoded text without mime type
            $image = substr($image, strpos($image, ',') + 1);
            // Get file extension
            $type = strtolower($type[1]); // jpg, png, gif

            // Check if file is an image
            if (!in_array($type, ['jpg', 'jpeg', 'gif', 'png'])) {
                throw new \Exception('invalid image type');
            }
            $image = str_replace(' ', '+', $image);
            $image = base64_decode($image);

            if ($image === false) {
                throw new \Exception('base64_decode failed');
            }
        } else {
            throw new \Exception('did not match data URI with image data');
        }

        $dir = 'images/';
        $file = Str::random() . '.' . $type;
        $absolutePath = public_path($dir);
        $relativePath = $dir . $file;
        if (!File::exists($absolutePath)) {
            File::makeDirectory($absolutePath, 0755, true);
        }
        file_put_contents($relativePath, $image);

        return $relativePath;
    }
    
}
