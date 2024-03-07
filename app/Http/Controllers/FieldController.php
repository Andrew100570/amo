<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class FieldController extends Controller
{

    public function showField() {
        return view('field');
    }
}
