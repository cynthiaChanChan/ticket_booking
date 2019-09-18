<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class InvitationsController extends Controller
{
    public function show($code) {
        // ### 后面添加database 找出$code
        return view('invitations.show');
    }
}
