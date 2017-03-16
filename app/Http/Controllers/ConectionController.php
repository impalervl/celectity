<?php

namespace App\Http\Controllers;

use App\Conection;
use App\Project;
use App\User;
use App\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ConectionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('conection.form');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
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

        if($project = $user->project->where('name','temp')->first()){

            $input['project_id'] = $project->id;
            $input['title'] = 'QF' . count($project->conection->all());
        }
        else{
            $project_result = Project::create(['name'=>'temp','user_id'=>$user->id]);

            $input['project_id'] = $project_result->id;
            $input['title'] = 'QF1';
        }

            $input['name']=$request->name;
            $input['product']='product';
            $input['nominal_current']=$request->electric_user_current;
            $input['poles']=$request->poles;
            $input['break_current']=($request->electric_user_current * 8);
            $input['outdoor_protection'] = 'GOOD';


        $create = Conection::create($input);

        return view('conection.result',compact('create'));
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
}
