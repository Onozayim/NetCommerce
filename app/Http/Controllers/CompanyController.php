<?php

namespace App\Http\Controllers;

use App\Http\Resources\CompanyResource;
use App\Models\Company;
use Illuminate\Http\Request;

class CompanyController extends Controller
{
    public function index(Request $request) {
        $companies = Company::with('tasks.user');
        $search = $request->input('search');

        if($search && is_numeric($search)) 
            $companies = $companies->where('id', $search);

        else if($search) 
            $companies = $companies->where('name', 'like', '%' . $search . '%');

        $companies = $companies->get();

        return CompanyResource::collection($companies)->collection;
    }
}
