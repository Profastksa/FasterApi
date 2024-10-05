<?php

namespace App\Http\Controllers;

use App\Models\SubArea;
use App\Models\AreaServices;
use App\Models\Area;
use Illuminate\Http\Request;

class SubAreaController extends Controller
{
    public function index($id)
    {
        return view('sub_areas.index', ['area_id' => $id]);
    }

    public function getSubAreas($id = null)
    {
        $data['subareas']  =  SubArea::when($id, fn ($q) => $q->where('area_id', $id))->get();
        return  response()->json($data, 200);
    }
    public function getAreasForServices($service_id = null, $sending)
    {

        if($sending)
        {
        $AreaSendingIds =  AreaServices::where('service_id', $service_id)->where('is_sending', 1)->get()->pluck('area_id');
        $data['Areas']  = Area::withCount('subAreas')->whereIn('id', $AreaSendingIds)->get();
        }
        else
        {
            $AreaResivingIds =  AreaServices::where('service_id', $service_id)->where('is_resiving', 1)->get()->pluck('area_id');
            $data['Areas']  = Area::withCount('subAreas')->whereIn('id', $AreaResivingIds)->get();
        }



        // =  SubArea::when($id, fn ($q) => $q->where('area_id', $id))->get();
        return  response()->json($data, 200);
    }



}
