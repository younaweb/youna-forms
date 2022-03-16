<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Http\Resources\FormResource;
use App\Models\Form;
use Illuminate\Http\Request;

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
        $forms=Form::where('user_id',$user->id)->orderBy('created_at','DESC')->paginate(10);
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
        $data['user_id']=auth()->user->id;
        $response=Form::create($data);
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

        if($form->user_id != auth()->user->id){
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
        if($form->user_id != auth()->user->id){
            return abort(403,'Unauthorized action');
        }
        $data=$request->validate([
            'title' => 'required|string|max:1000',
            'image' => 'string',
           
            'status' => 'required|boolean',
            'description' => 'nullable|string',
            'expire_date' => 'nullable|date|after:tomorrow',
            'questions' => 'array'
        ]);
        $data['user_id']=auth()->user->id;
        $response=$form->update($data);
        return new FormResource($response);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Form  $form
     * @return \Illuminate\Http\Response
     */
    public function destroy(Form $form)
    {
        if($form->user_id != auth()->user->id){
            return abort(403,'Unauthorized action');
        }
        $form->delete();
        return response('',204);


    }
}
