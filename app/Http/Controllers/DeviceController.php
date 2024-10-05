<?php

namespace App\Http\Controllers;

use App\Models\Device;
use Barryvdh\DomPDF\Facade\Pdf as FacadePdf;
use Barryvdh\DomPDF\PDF as DomPDFPDF;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use PDF;

class DeviceController extends Controller
{

    public function index()
    {
        $devices = Device::all();
        return view('device.index', compact('devices'));
    }
    public function addDevice()
    {
        return view('device.add');
    }
    public function StoreDevice(Request $request)
    {
        //  Validate The Request
        $request->validate([
            'name' => 'required',
            'phone' => 'required',
        ]);
        // Save The Whats App Data InTo Database
        Device::create(
            [
                'name' => $request->name,
                'phone' => $request->phone,
                'status' => 'connected',
            ]
        );
        // dd(Device::all());
        // dd($request->phone . ' Hello');
        return redirect()->route('scanDevice', $request->phone);
    }
    public function scanDevice($name)
    {
        // dd($name);
        // dd(env('URL_WA_SERVER'));
        $find = Http::withoutVerifying()->get(env('URL_WA_SERVER', '127.0.0.1:8000') . '/sessions/find/' . $name);
        $cek = json_decode($find->getBody());
        // dd($cek);
        if ($cek->message == "Session found.") {
            $image = 'https://blog.jostle.me/hubfs/why-connection-matters16x9.png';
            DB::table('devices')->where('name', $name)->update(['status' => 'connected', 'updated_at' => now()]);
        } else {
            DB::table('devices')->where('name', $name)->update(['status' => 'disconnected', 'updated_at' => now()]);
            $cekMD = DB::table('devices')->select('multidevice')->where('name', $name)->first();
            $islegacy = "false";
            $response = Http::withoutVerifying()->post(env('URL_WA_SERVER',  '127.0.0.1:8000') . '/sessions/add', ['id' => $name, 'isLegacy' => $islegacy]);
            $res = json_decode($response->getBody());
            $image = $res->data->qr;
        }

        $data = [];
        $data['page_title'] = 'Scan Device';
        $data['result'] = $image;
        $data['script_js'] = 'setTimeout(function(){window.location.reload(1);}, 20000);';
        // Please use view method instead view method from laravel
        // dd($data);
        return view('device.scan', $data);
    }


    public function destroy($id)
    {
        Device::findOrFail($id)->delete();
        return redirect()->back();
    }

    public function exportPdf()
    {
        $devices = Device::all();
        // return view('device.index' , $devices);
        view('device.index', compact('devices'));
        $pdf = FacadePdf::loadView('device.index', compact('devices'))->setOptions(['defaultFont' => 'sans-serif']);
        // download PDF file with download method
        $content = ($pdf->download('pdf_file.pdf')->getOriginalContent());
        Storage::disk('public')->put('clients/reports/week/1/week.pdf', $content);
        // dd($disk);
    }
}
