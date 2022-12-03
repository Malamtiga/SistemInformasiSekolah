<?php

namespace App\Controllers;

use App\Controllers\BaseController;

class ProfilesiswaController extends BaseController
{
    public function index()
    {
        return view('backend/siswa/profile');
    }
}
