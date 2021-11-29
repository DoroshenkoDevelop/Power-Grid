<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class SearchController extends Controller
{

    public function search()
    {
        //Query search ищет по полям в базе
        $users = User::search()->get();
        return view('search',compact('users'));
    }
}
