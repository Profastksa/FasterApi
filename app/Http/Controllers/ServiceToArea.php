<?php

namespace App\Http\Controllers;

use App\Models\Area;
use App\Models\AreaServices;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ServiceToArea extends Controller
{
    public function index(Request $request)
    {

        // return $request;
        $validatedData = Validator::make($request->all(), [
            'name' => 'required|string',
            'service' => 'required',
        ]);
        if ($validatedData->fails())
            return redirect()->back()->with('error', __('translation.exception.error'));
        $services = $request->service;
        // dd($services);
        $area =   Area::create(['name' => $request->name]);

        foreach ($services as $key => $value) {
            // dd($value);
            if ($value !== 'on') {
                $firstVal = $value[0] == 'sendeings'  ? boolval($value[0] ?? null)  : 0;
                $secondVal =  $value[0] == 'resiving' ? boolval($value[0] ?? null) : (isset($value[1])  && $value[1] == 'resiving' ? boolval($value[1] ?? null) : 0);
            } else {
                $firstVal =  $secondVal = 0;
            }

            // dd($secondVal);
            $IsServiceModel =    ['area_id' => $area->id, 'service_id' => $key, 'is_sending' => $firstVal, 'is_resiving' => $secondVal];
            // dd($IsServiceModel);


            AreaServices::create($IsServiceModel);
            // dd('firest was create');

        }
        session()->flash('success', __('translation.item.created.successfully'));
        return redirect()->route('areas.index')->with('success', __('translation.item.created.successfully'));
    }
    public function UpdateAreaServices(Request $request)
    {

     try{
        $validator  = Validator::make($request->all(), [
            'id' => 'integer',
            'name' => 'required',
            // 'service' => 'required',
        ]);
        if ($validator->fails())
            return redirect()->back()->with('error', __('translation.error.exception'));

        $services = $request->service;
        // dd($services);

        $area =   Area::find($request->id);
        $area->name = $request->name;
        $area->save();

        // delted serviecs for area
        $deleted =  AreaServices::where('area_id', $request->id)->get()->pluck('id');
        // dd($deleted->count);
        if ($deleted) {
            AreaServices::whereIn('id' , $deleted)->delete();
        }
        foreach ($services as $key => $value) {
            // dd($value);
            if ($value !== 'on') {
                $firstVal = $value[0] == 'sendeings'  ? boolval($value[0] ?? null)  : 0;
                $secondVal =  $value[0] == 'resiving' ? boolval($value[0] ?? null) : (isset($value[1])  && $value[1] == 'resiving' ? boolval($value[1] ?? null) : 0);
            } else {
                $firstVal =  $secondVal = 0;
            }

            // dd($secondVal);
            $IsServiceModel =    ['area_id' => $area->id, 'service_id' => $key, 'is_sending' => $firstVal, 'is_resiving' => $secondVal];
            // dd($IsServiceModel);
            AreaServices::create($IsServiceModel);
        }
        return redirect()->route('areas.index')->with('success', __('translation.item.created.successfully'));
     }catch(Exception $e){
            return redirect()->back()->with('error', __('translation.exception.error'));
     }
        // } else {
        //     return redirect()->back()->with('error', __('translation.exception.error'));
        // }
    }
}
