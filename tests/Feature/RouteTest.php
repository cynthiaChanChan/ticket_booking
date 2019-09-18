<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class RouteTests extends TestCase
{
    /** @test */
    function new()
    {
        $this->get('/backstage/concerts/new');
    }
}