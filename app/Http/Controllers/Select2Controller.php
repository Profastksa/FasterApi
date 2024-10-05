<?php

namespace App\Http\Controllers;

use App\Models\Representative;
use Illuminate\Http\Request;

class Select2Controller extends Controller
{
    //

    public function RepresetiveAjaxSearch(Request $request)
    {

        $search = $request->search;
        $prams = ['fullname', 'phone'];

        $employees = Representative::when($search != null, function ($query) use ($prams, $search) {
            $query->orWhere(function ($q) use ($prams, $search) {
                foreach ($prams as  $key) {
                    $q->orWhere($key, 'like', '%' . $search . '%');
                        // ->orWhere($key, 'like',  '%' . $search)
                        // ->orWhere($key, 'like',   $search . '%')
                        // ->orWhere($key, 'like', $search);
                }
            });
        })



            ->orderby('fullname', 'asc')->select('id', 'fullname')
            ->limit(5)->get();
        //  Return Reponose
        $response = array();
        foreach ($employees as $employee) {
            $response[] = array(
                "id" => $employee->id,
                "text" => $employee->fullname
            );
        }
        return response()->json($response);
    }
}
