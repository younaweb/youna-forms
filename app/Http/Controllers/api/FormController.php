<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Http\Resources\FormQuestionResource;
use App\Http\Resources\FormResource;
use App\Models\Form;
use App\Models\FormQuestion;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

use function PHPSTORM_META\type;

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
        $forms=Form::where('user_id',$user->id)->orderBy('created_at','DESC')->paginate(3);
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
            'questions' => 'array',
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

        // save questions 
       
        foreach($data['questions'] as $question){
            $question['form_id']= $response->id;
            $this->saveQuestion($question);
        }
       
       
       


        return new FormResource($response);

    }
    public function saveQuestion($question)
    {
       
        if (is_array($question['data'])) {
            $question['data'] = json_encode($question['data']);
        }
      
       $data= Validator::make($question, [
          'type'=>['required', Rule::in(['textarea','text', 'select', 'radio', 'checkbox'])],
           'question'=>'required|string',
           'description'=>'nullable|string',
           'data' => 'present',
        'form_id' => 'required'
       ]);
       
       $formQuestion=FormQuestion::create($data->validated());
      return $formQuestion;
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
            'expire_date' => 'nullable|date',
           
        ]);
        $data_questions=$request->validate([
           
            'questions'=>'array'
           
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
        $form->update($data);


        // Get ids as plain array of existing questions
        $existingIds = $form->Questions()->pluck('id')->toArray();
        // Get ids as plain array of new questions
        $newIds = Arr::pluck($data_questions['questions'], 'id');
        // Find questions to delete
        $toDelete = array_diff($existingIds, $newIds);
        //Find questions to add
        $toAdd = array_diff($newIds, $existingIds);

        // Delete questions by $toDelete array
        FormQuestion::destroy($toDelete);

        // Create new questions
        foreach ($data_questions['questions'] as $question) {
            if (in_array($question['id'], $toAdd)) {
                $question['form_id'] = $form->id;
                $this->saveQuestion($question);
            }
        }

        // Update existing questions
        $questionMap = collect($data_questions['questions'])->keyBy('id');
        foreach ($form->questions as $question) {
            if (isset($questionMap[$question->id])) {
                $this->updateQuestion($question, $questionMap[$question->id]);
            }
        }
   
        return new FormResource($form);

    }

    private function updateQuestion(FormQuestion $question, $data)
    {
        if (is_array($data['data'])) {
            $data['data'] = json_encode($data['data']);
        }
        $validator = Validator::make($data, [
            'id' => 'exists:form_questions,id',
            'question' => 'required|string',
            'type'=>['required', Rule::in(['textarea','text', 'select', 'radio', 'checkbox'])],

            'description' => 'nullable|string',
            'data' => 'present',
        ]);

        return $question->update($validator->validated());
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
