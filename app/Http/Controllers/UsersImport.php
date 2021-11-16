<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class UsersImport extends Controller
{
    public function import(){
        Excel::import(new \App\Imports\UsersImport(), 'users.xslx');
        return redirect('/')->with('success','All good!');
    }
}
