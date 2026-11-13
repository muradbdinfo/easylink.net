<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use Inertia\Response;

/** Speed test page. The test itself is an embedded third-party widget (address editable in the admin panel). */
class SpeedTestController extends Controller
{
    public function index(): Response
    {
        return Inertia::render('SpeedTest');
    }
}
