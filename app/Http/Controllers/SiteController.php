<?php

namespace App\Http\Controllers;

use App\Models\Plan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

class SiteController extends Controller
{
    public function index(Plan $plan)
    {
        $data['plans']  = $plan->with('features')->get();
        return view('home.index', $data);
    }

    public function createSessionPlan(Plan $plan, $plan_id)
    {
        $plan = $plan->find($plan_id);
        if (!$plan) return Redirect::route('home');

        session()->put('plan', $plan);
        
        return Redirect::route('subscriptions.checkout');
    }
}
