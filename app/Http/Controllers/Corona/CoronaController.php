<?php

namespace App\Http\Controllers\Corona;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;


use App\Models\Corona\CoronaUser;
use App\Models\Corona\CoronarUserTemp;
use App\Models\Corona\CoronaOthersTemp;
use Carbon\Carbon;

class CoronaController extends Controller
{
    public function Dashboard(){

        $totalUser = CoronaUser::count();
        $todayTepmMeasured = CoronarUserTemp::whereDate('created_at', Carbon::today())->count();
        $todayOtherTepmMeasured = CoronaOthersTemp::whereDate('created_at', Carbon::today())->count();
        $totalTepmRec = CoronarUserTemp::count();



        return view('admin.corona.dashboard', compact('totalUser', 'todayTepmMeasured', 'todayOtherTepmMeasured', 'totalTepmRec'));
    }
}
