<?php

namespace App\Http\Controllers;

use App\Models\colour;
use App\Models\Material;
use App\Models\PersonProcess;
use App\Models\Process;
use App\Models\User;
use Illuminate\Http\Request;

class ApiController extends Controller
{
    public function getRoles($id){
        $user= User::find($id);
        $roles= $user->personProcess;
        return response()->json($roles);
    }

    public function getProcessUser($id){
        $processid= Process::find($id)->process_type;
        $process= PersonProcess::where('process_type_id',$processid)->get();
        $userid= $process->pluck('user_id');
        $user= User::whereIn('id',$userid)->get();
        return response()->json($user);
    }

    public function getMaterialQuantity($id){
        $material=Material::find($id);
        return response($material->material_quantity);
    }

    public function searchColour(Request $request){
        $colour= $request->colour_name;
        $colours= colour::where('colour_name','like','%'.$colour.'%')->get();
        return response()->json($colours);
    }

}
