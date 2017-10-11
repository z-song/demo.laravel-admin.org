<?php

namespace App\Admin\Controllers\World;

use App\Http\Controllers\Controller;
use App\Models\World\City;
use App\Models\World\Country;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ApiController extends Controller
{
    public function cities(Request $request)
    {
        $q = $request->get('q');

        return City::where('Name', 'like', "%$q%")->paginate(null, [DB::raw('ID as id'),DB::raw('Name as text')]);
    }

    public function countries(Request $request)
    {
        $q = $request->get('q');

        return Country::where('Name', 'like', "%$q%")->paginate(null, [DB::raw('Code as id'),DB::raw('Name as text')]);
    }
}