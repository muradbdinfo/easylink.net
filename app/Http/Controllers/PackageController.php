<?php

namespace App\Http\Controllers;

use App\Models\Package;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class PackageController extends Controller
{
    public function index(Request $request): Response
    {
        $type = $request->query('type', 'home');
        $type = in_array($type, ['home', 'corporate']) ? $type : 'home';

        return Inertia::render('Packages/Index', [
            'packages' => Package::active()->ofType($type)->get(),
            'type' => $type,
        ]);
    }
}
