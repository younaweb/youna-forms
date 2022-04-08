<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Http\Resources\FormAnswerResource;
use App\Http\Resources\FormDashboardResource;
use App\Models\Form;
use App\Models\FormAnswer;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $user = $request->user();

        // Total Number of Forms
        $total = Form::query()->where('user_id', $user->id)->count();

        // Latest Form
        $latest = Form::query()->where('user_id', $user->id)->latest('created_at')->first();

        // Total Number of answers
        $totalAnswers = FormAnswer::query()
            ->join('forms', 'form_answers.form_id', '=', 'forms.id')
            ->where('forms.user_id', $user->id)
            ->count();

        // Latest 5 answer
        $latestAnswers = FormAnswer::query()
            ->join('forms', 'form_answers.form_id', '=', 'forms.id')
            ->where('forms.user_id', $user->id)
            ->orderBy('end_date', 'DESC')
            ->limit(5)
            ->getModels('form_answers.*');

        return [
            'totalForms' => $total,
            'latestForm' => $latest ? new FormDashboardResource($latest) : null,
            'totalAnswers' => $totalAnswers,
            'latestAnswers' => FormAnswerResource::collection($latestAnswers)
        ];
    }
}
