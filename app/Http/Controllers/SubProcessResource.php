<?php

namespace App\Http\Controllers;

use App\Models\Material;
use App\Models\MaterialHistory;
use App\Models\Process;
use App\Models\processMaterial;
use App\Models\SubProcessHistory;
use App\Models\SubProses;
use Illuminate\Http\Request;

class SubProcessResource extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
        dd($request);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\SubProses  $subProses
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $subProses = SubProcessHistory::find($id);
        $listProcess = $subProses->subProcess->process->production->type->production_process->pluck('process_type_id');

        return view('subproses.show', compact('subProses', 'listProcess'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\SubProses  $subProses
     * @return \Illuminate\Http\Response
     */
    public function edit(SubProses $subProses)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\SubProses  $subProses
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        SubProcessHistory::create([
            'sub_process_id' => $id,
            'quantity' => $request->quantityAmbil
        ]);

        return redirect()->back()->with('success', 'Sub Proses Berhasil Diupdate');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\SubProses  $subProses
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $subProses = SubProses::find($id);
        $subProsesHistory = SubProcessHistory::where('sub_process_id', $id)->get();
        foreach ($subProsesHistory as $subProsesHistory) {
            $subProsesHistory->delete();
        }
        $subProses->delete();

        return redirect()->back()->with('success', 'Sub Proses Berhasil Dihapus');
        
    }
    public function destroyHistory($id)
    {
        $subProsesHistory = SubProcessHistory::find($id);
        $subProses=SubProses::find($subProsesHistory->sub_process_id);
        $subProses->sub_proses_actual=$subProses->sub_proses_actual - $subProsesHistory->quantity;
        $subProses->save();

        $subProsesHistory->delete();

        return redirect()->back()->with('success', 'Sub Proses Berhasil Dihapus');
        
    }

    public function updateQuantity (Request $request, SubProses $subproses) {
        $listProcess= Process::where('production_id',$subproses->process->production_id)->get()->pluck('id')->toArray();
        $index=array_search($request->process_id, $listProcess);

        //array append
       

        $processMaterial[]=$subproses->processMaterial;
        $processMaterial[]=processMaterial::where('process_material_name',$subproses->processMaterial->process_material_name)->where('process_id',$listProcess[$index+1])->first();

        foreach ($processMaterial as $pm) {
            $pm->process_material_quantity=$pm->process_material_quantity+$request->quantity;
            $pm->save();
            $pm->material->material_quantity=$pm->material->material_quantity+$request->quantity;
            $pm->material->save();

            MaterialHistory::create([
                'material_id'=>$pm->material->id,
                'quantity'=>$request->quantity,
                'description'=>'Pengambilan Untuk '.$subproses->sub_proses_name
            ]);
        }
        $subProsesHistory=SubProcessHistory::find($request->sph_id);
        $subProsesHistory->is_done=true;
        $subProsesHistory->save();

        $subproses->sub_proses_actual=$subproses->sub_proses_actual+$request->quantity;
        $subproses->save();

        return back()->with('success', 'Sub Proses Berhasil Diupdate');
    }

    public function reportPage($id) {
        $subProses = SubProcessHistory::find($id);

        return view('subproses.report', compact('subProses'));
    }

    public function report(Request $request, $id) {
        $subProsesHistory = SubProcessHistory::find($id);
        $quantityAman=$request['quantity']-$request['quantity_rusak'];
        $subproses = SubProses::find($subProsesHistory->sub_process_id);
        $listProcess= Process::where('production_id',$subproses->process->production_id)->get()->pluck('id')->toArray();
        $index=array_search($request->process_id, $listProcess);

        //array append
        $processMaterial[]=$subproses->processMaterial;
        $processMaterial[]=processMaterial::where('process_material_name',$subproses->processMaterial->process_material_name)->where('process_id',$listProcess[$index+1])->first();

        foreach ($processMaterial as $pm) {
            $pm->process_material_quantity=$pm->process_material_quantity+$quantityAman;
            $pm->save();
            $pm->material->material_quantity=$pm->material->material_quantity+$quantityAman;
            $pm->material->save();

            MaterialHistory::create([
                'material_id'=>$pm->material->id,
                'quantity'=>$quantityAman,
                'description'=>'Pengambilan Untuk '.$subproses->sub_proses_name
            ]);
        }
        $subProsesHistory=SubProcessHistory::find($request->sph_id);
        $subProsesHistory->quantity=$quantityAman;
        $subProsesHistory->is_done=true;
        $subProsesHistory->save();

        $subproses->sub_proses_actual=$subproses->sub_proses_actual+$quantityAman;
        $subproses->save();

        $processList=Process::where('production_id',$subproses->process->production_id)->get();
        $processList=$processList->pluck('process_type')->toArray();
        if(!in_array(7, $processList)) {
        $process=Process::create([
            'production_id'=>$subproses->process->production_id,
            'process_type'=>7,
            'process_name'=>'Permak untuk '.$subproses->process->production->production_name,
            'process_status'=>1,
            'process_start_date'=>date('Y-m-d H:i:s'),
            'process_end_date'=>date('Y-m-d H:i:s'),
        ]);
        Process::create([
            'production_id'=>$subproses->process->production_id,
            'process_type'=>5,
            'process_name'=>'Finishing Permak '.$subproses->process->production->production_name,
            'process_status'=>1,
            'process_start_date'=>date('Y-m-d H:i:s'),
            'process_end_date'=>date('Y-m-d H:i:s'),
        ]);
        }
        $process=Process::where('production_id',$subproses->process->production_id)->where('process_type',7)->first();
        $findMaterial=Material::where('material_name',$subproses->processMaterial->process_material_name.'(Rusak)')->first();
        $productionProcess=Process::where('production_id',$subproses->process->production_id)->get();
        $productionProcess=$productionProcess->pluck('id')->toArray();
        
        if($findMaterial == null) {
            $material=Material::create([
                'material_name'=>$subproses->processMaterial->process_material_name.'(Rusak)',
                'material_description'=>$subproses->processMaterial->process_material_name.' (Rusak)',
                'material_quantity'=>$request['quantity_rusak'],
                'material_measure_unit'=>'pcs',
                'material_sub_category_id'=>999,
                'bagian_baju_id'=>5,
            ]);
            $pms=processMaterial::create([
                'process_id'=>$process->id,
                'material_id'=>$material->id,
                'process_material_name'=>$material->material_name,
                'process_material_quantity'=>$request['quantity_rusak'],
                'process_material_status'=>'Input Produksi',
            ]);
            
            $index=array_search($pms->process->id, $productionProcess);

            processMaterial::create([
                'process_id'=>$productionProcess[$index-2],
                'material_id'=>$material->id,
                'process_material_name'=>$material->material_name,
                'process_material_quantity'=>$request['quantity_rusak'],
                'process_material_status'=>'Output Produksi',
            ]);

            
        } else{
            $materialProcess=$findMaterial->processMaterial;
            foreach ($materialProcess as $mp) {
                $mp->process_material_quantity=$mp->process_material_quantity+$request['quantity_rusak'];
                $mp->save();
            }

        }

        

        return redirect()->back()->with('success', 'Laporan Berhasil Dikirim');
    }
}
