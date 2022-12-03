<?php

namespace App\Controllers;

use App\Controllers\BaseController;

class SiswadashboardController extends BaseController
{
    public function index()
    {
        return view('backend/siswa/dashboard'); 
    }
}
