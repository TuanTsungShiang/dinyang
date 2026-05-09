<?php

namespace App\Http\Controllers;

use App\Models\Job;

class CareersController extends Controller
{
    public function index()
    {
        $jobs = Job::where('is_active', true)
            ->orderBy('sort_order')
            ->get();

        return view('careers.index', compact('jobs'));
    }
}
