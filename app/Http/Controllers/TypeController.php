<?php

namespace App\Http\Controllers;

use App\Models\Type;
use Illuminate\Http\Request;

class TypeController extends Controller
{
    public function index()
    {
        $types = Type::paginate(10);

        return view('types.index', compact('types'));
    }

    public function store(Request $request)
    {
    
    }
}
