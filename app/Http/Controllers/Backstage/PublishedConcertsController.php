<?php

namespace App\Http\Controllers\Backstage;

use App\Concert;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PublishedConcertsController extends Controller
{
    public function store()
    {
        $concert = Concert::find(request('concert_id'));

        abort_if($concert->isPublished(), 422); //Unprocessable Entity

        $concert->publish();

        return redirect()->route('backstage.concerts.index');

    }
}
