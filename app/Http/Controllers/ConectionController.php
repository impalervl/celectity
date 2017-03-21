<?php

namespace App\Http\Controllers;

use App\Conection;
use App\Http\Requests\ConectionRequest;
use App\Project;
use App\User;
use App\Role;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ConectionController extends Controller
{


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    static public function index()
    {

        $cnt = 0;

        $user = Auth::user();

        $projects = $user->project->all();

        $project_names[-1] = 'выбрать';

        foreach ($projects as $project) {
            $project_names[$project->name] = $project->name;
            $conections_temp[] = $project->conection->all();
            $cnt++;
        }

        for ($i = 0; $i < $cnt; $i++) {
            $row = count($conections_temp[$i]);
            for ($j = 0; $j < $row; $j++) {
                $conections[] = $conections_temp[$i][$j];
            }
        }

        return view('results.index', compact('conections', 'project_names'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('conection.form');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $input = $request->all();

        $cnt = 0;

        for ($i = 0; $i < ((count($input['creates'])) / 10); $i++) {
            for ($j = 0; $j < 9; $j++) {
                $outputs[$i][$j] = $input['creates'][$cnt];
                $cnt++;
            }
        }

        foreach ($outputs as $output) {

            Conection::create([
                'name' => $output[1],
                'title' => $output[2],
                'product' => $output[3],
                'nominal_current' => $output[4],
                'poles' => $output[5],
                'break_current' => $output[6],
                'outdoor_protection' => $output[7],
                'project_id' => $output[8]
            ]);
        }

        return redirect('/conection');
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {

        Conection::findOrFail($id)->delete();

        return redirect('/conection');

    }

    public function destroyone($id)
    {

        dd($id);

    }

    public function destroyAll(Request $request)
    {


        dd($request->all());

    }

    static public function power_calculation($current, $project_id)
    {

        $current_start = $current * 8;
        $nominal = DB::table('power')
            ->where([['nominal_current', '>=', $current]])
            ->min('nominal_current');

        if($current>80){
            $inputs = DB::table('power')
                ->where([['nominal_current', '=', $nominal]])
                ->get();
        }
        else{
            $inputs = DB::table('power')
                ->where([['nominal_current', '=', $nominal], ['break_current', '>', ($current * 800) / 1000]])
                ->get();
        }

        $title = 'QF' . Project::get()->count();

        foreach ($inputs as $input) {

            $input = json_decode(json_encode($input), true);
            $input['voltage'] = 380;
            $input['project_id'] = $project_id;
            $input['title'] = $title;
            $input['poles'] = 3;
            $cof = 12;

            if ($current_start < ($cof * $input['nominal_current'])) {
                $creates[] = $input;
            }

        }
        if (isset($creates))
            return $creates;

    }

    static public function calculation(ConectionRequest $request)
    {

        $user = Auth::user();

        $check = $request->all();

        if ($request->electric_user == 1 && $request->voltage == 380) {
            $current = 1.1 * ($request->capacity / (1.73 * 380 * 0.9 * 0.9));
            $current_start = 8 * $current;
            $init = 1;
        }
        else{
            $current = 1.1 * ($request->capacity / $request->voltage);
            $init = 0;
        }

        $poles = $request->poles;

        $nominal = DB::table('breakcircuit')
            ->where([['nominal_current', '>=', $current],['nominal_current', '<', $current*2],['poles', '=', $poles]])
            ->min('nominal_current');

        $inputs = DB::table('breakcircuit')
            ->where([['nominal_current', '=', $nominal], ['poles', '=', $poles]])
            ->get();

        if (isset($check['parent'])) {
            $project = $user->project->last();
            $title = $request->title;
        }
        else
        {
            $project = $user->project->where('name', 'temp')->first();
            $title = 'QF' . Project::get()->count();
            if (!isset($project)) {
                $project = Project::create(['name' => 'temp', 'user_id' => $user->id]);
            }

        }

        foreach ($inputs as $input) {

            $input = json_decode(json_encode($input), true);
            $input['voltage'] = $request->voltage;
            $input['project_id'] = $project->id;
            $input['title'] = $title;

            $results = explode(" ", $input['name']);

            foreach ($results as $result) {
                if ($result == 'B') {
                    $cof = 3;
                } else if ($result == 'C') {
                    $cof = 6;
                } else if ($result == 'D') {
                    $cof = 12;
                } else {
                    $cof = 3;
                }

            }
            if ($init == 1) {
                if ($current_start < ($cof * $input['nominal_current'])) {
                    $creates[] = $input;
                }
            }
            else
            {
                if (($cof == 3) || ($cof == 6)) {
                    $creates[] = $input;
                }
            }
        }

        if ($poles == 3){
            $creates_power = ConectionController::power_calculation($current, $project->id);
        }

        if(isset($creates_power)){
            foreach ($creates_power as $create_power) {
                $creates[] = $create_power;
            }
        }

        if (isset($check['parent'])) {
            return $creates;
        } else {
            return view('conection.result', compact('creates'));
        }


    }

    static public function parents(Model $project)
    {

        $conections = $project->conection->all();

        foreach ($conections as $conection) {

            $title_section = explode('.', $conection->title);

            if ($title_section[0] == 'QF1') {
                if (!isset($currents1[$title_section[1] - 1])) {
                    $currents1[] = $conection->nominal_current;
                }
                $poless1[] = $conection->poles;
            }

            if ($title_section[0] == 'QF2') {
                if (!isset($currents2[$title_section[1] - 1])) {
                    $currents2[] = $conection->nominal_current;
                }
                $poless2[] = $conection->poles;
            }

            if ($title_section[0] == 'QF3') {
                if (!isset($currents3[$title_section[1] - 1])) {
                    $currents3[] = $conection->nominal_current;
                }
                $poless3[] = $conection->poles;
            }
        }

        $current1 = 0;
        $current2 = 0;
        $current3 = 0;

        foreach ($currents1 as $current) {
            $current1 = $current1 + $current;
        }
        $title = 'QF1';
        $poles1 = max($poless1);
        ConectionController::parents_calculate($current1, $poles1, $title, $project->id);

        if (isset($currents2)) {
            foreach ($currents2 as $current) {
                $current2 = $current2 + $current;
            }
            $title = 'QF2';
            $poles2 = max($poless2);
            ConectionController::parents_calculate($current2, $poles2, $title, $project->id);
        }

        if (isset($currents3)) {
            foreach ($currents3 as $current) {
                $current3 = $current3 + $current;
            }
            $title = 'QF3';
            $poles3 = max($poless3);
            ConectionController::parents_calculate($current3, $poles3, $title, $project->id);
        }

        $master_current = $current1 + $current2 + $current3;
        $title = 'QF0';
        $poles = 3;
        
        ConectionController::parents_calculate($master_current, $poles, $title, $project->id);

    }

    static public function parents_calculate($current, $poles, $title, $project_id)
    {

        $current = 1.1 * $current;

        if ($poles == 3) {
            $nominal = DB::table('power')
                ->where([['nominal_current', '>=', $current]])
                ->min('nominal_current');

            if($title != 'QF0'){
                $inputs = DB::table('power')
                    ->where([['nominal_current', '=', $nominal], ['break_current', '>', ($current * 200) / 1000]])
                    ->get();
                $power_init = 1;
            }
            else{
                $inputs = DB::table('power')
                    ->where([['nominal_current', '=', $nominal]])
                    ->get();
                $power_init = 1;
            }

        }
        else if ($poles == 2)
        {
            $nominal = DB::table('breakcircuit')
                ->where([['nominal_current', '>=', $current],['nominal_current', '<', $current*2], ['poles', '=', $poles]])
                ->min('nominal_current');

            $inputs = DB::table('breakcircuit')
                ->where([['nominal_current', '=', $nominal], ['poles', '=', $poles]])
                ->get();
            $power_init = 0;

        }
        else
        {
            $nominal = DB::table('breakcircuit')
                ->where([['nominal_current', '>=', $current],['nominal_current', '<', $current*2], ['poles', '=', $poles]])
                ->min('nominal_current');

            $inputs = DB::table('breakcircuit')
                ->where([['nominal_current', '=', $nominal], ['poles', '=', $poles]])
                ->get();
            $power_init = 0;

        }
        foreach ($inputs as $input) {
            $input = json_decode(json_encode($input), true);
            if ($power_init == 1) {
                $input['poles'] = 3;
            }
            $input['title'] = $title;
            $input['project_id'] = $project_id;
            Conection::create($input);
        }

    }

}
