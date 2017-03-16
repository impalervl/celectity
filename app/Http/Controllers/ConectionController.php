<?php

namespace App\Http\Controllers;

use App\Conection;
use App\Project;
use App\User;
use App\Role;
use App\Custom\Trans;
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
    public function index(){
        $cnt =0;
        $user = Auth::user();
        $projects = $user->project->all();
        foreach ($projects as $project){
            $conections_temp[] = $project->conection->all();
            $cnt++;
        }
        for($i = 0; $i < $cnt; $i++){
            $row = count($conections_temp[$i]);
            for($j = 0; $j < $row; $j++){
                $conections[] = $conections_temp[$i][$j];
            }
        }
        return view('results.index',compact('conections'));
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
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $user = Auth::user();
        if($request->electric_user == 1 && $request->voltage == 380){
            $current = 1.1 * ($request->capacity/(1.73 * 380 * 0.9 * 0.9));
            $current_start = 8 * $current;
    }
        else{
            $current = 1.1 * ($request->capacity/$request->voltage);
        }

        $poles = $request->poles;

        if($nominal = DB::table('breakcircuit')
            ->where([['nominal_current', '>=', $current],['nominal_current', '<', $current *2 ],['poles','=',$poles]])
            ->value('nominal_current')){

            $inputs =  DB::table('breakcircuit')
                ->where([['nominal_current', '=', $nominal],['poles','=',$poles]])
                ->get();
        }
        else{
            $nominal = DB::table('power_breakcircuit')
                ->where([['nominal_current', '>=', $current]])
                ->value('nominal_current');

            $inputs =  DB::table('power_breakcircuit')
                ->where([['nominal_current', '=', $nominal]])
                ->get();
        }

        foreach($inputs as $input){

            $input = json_decode(json_encode($input),true);

            if($project = $user->project->where('name','temp')->first()){
                $input['project_id'] = $project->id;
                $input['title'] = 'QF' . count($project->conection->all());
            }
            else{
                $project_result = Project::create(['name'=>'temp','user_id'=>$user->id]);

                $input['project_id'] = $project_result->id;
                $input['title'] = 'QF1';
            }
            /*if($current_start){
                if($current_start < ((parsed($input['name'])) * $input['nominal_current'])){

                    $creates[] = Conection::create($input);
                }
            }
            else{

                $creates[] = Conection::create($input);
            }*/
            $creates[] = Conection::create($input);
        }
        
        return view('conection.result',compact('creates'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {

        Conection::findOrFail($id)->delete();

        return redirect('/conection');

    }
/*
    public function destroyAll($creates){
        
        foreach($creates as $create){
            Conection::findOrFail($create->id)->delete();
        }
    }*/
}
