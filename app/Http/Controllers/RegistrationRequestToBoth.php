<?php

namespace App\Http\Controllers;

use App\Events\SendNotifcationWithFireBase;
use App\Models\Client;
use App\Models\Representative;
use Illuminate\Http\Request;
use App\Scope\ApprovedScope;
use Exception;
use App\Exceptions\NotifcationException;
use App\Models\clientsFile;
use Illuminate\Support\Facades\Storage;
use Mail;
use Illuminate\Database\Eloquent\ModelNotFoundException;


use App\Mail\ProoFast;
use function PHPSTORM_META\type;

class RegistrationRequestToBoth extends Controller
{
    public function getUnAprrovedclient(){
        $Clients = Client::with('Files')->withoutGlobalScope(new ApprovedScope)->where('is_approved' , 0)->paginate(1000);
        // return $Clients[0];
        return  view('clients.aprrove' ,compact('Clients'));
    }

    public function getUnAprrovedrepresentatives(){
        $Representatives = Representative::withoutGlobalScope(new ApprovedScope)->where('is_approved' , 0)->paginate(1000);
        return  view('representatives.approve' ,compact('Representatives'));
    }

    public function aprrove($id , $type){
        // return $type;
        try{

        if($type == 'client'){
            $User =Client::withoutGlobalScope(new ApprovedScope)->where('id' , $id)->first();
            $User->update(['is_approved' => 1]);
                $mailData=[
                'email'=> $User->email,
                'name'=>$User->fullname,
                'phone'=>$User->phone,
            ];
            Mail::to($User->email)->send(new ProoFast($mailData));
        }
        else{
            $User =Representative::withoutGlobalScope(new ApprovedScope)->where('id' , $id)->first();
            $User->update(['is_approved' => 1]);
                $mailData=[
                'title'=> $User->email,
                'body'=>$User->fullname,
                'cc'=>$User->phone,
            ];
            Mail::to($User->email)->send(new ProoFast($mailData));
        }
        // dd($User);
        event(new SendNotifcationWithFireBase($User->message_token ,__('translation.Registration_Account'), __('translation.Your_account_Has_Been_Approved') ));
        session()->flash('success' ,__('translation.approve_user'));
        }
        catch(NotifcationException $Ne){
            session()->flash('error' ,__('translation.Notification_Send_Error'));
        }
        catch(Exception $e){
            // return $e;
       // session()->flash('error' ,__('translation.exception.error'));
       session()->flash('success' ,__('translation.approve_user'));
        // return $e;
        }
        return redirect()->back();
    }

    public function delete($id, $type)
    {
        try {
            if ($type == 'client') {
                $User = Client::withoutGlobalScope(new ApprovedScope)->findOrFail($id);
                $User->delete();
            } else {
                $User = Representative::withoutGlobalScope(new ApprovedScope)->findOrFail($id);
                $User->delete();
            }
            session()->flash('success', __('translation.item.deleted.successfully'));
        } catch (ModelNotFoundException $e) {
            session()->flash('error', __('translation.data.not.found'));
        } catch (Exception $e) {
            session()->flash('error', __('translation.error.exception'));
        }
        return redirect()->back();
    }

    public function attachments($type , $id){
        // return $id;

        if($type == 'clients') $DynamicModel = Client::with('Files')->withoutGlobalScope(new ApprovedScope)->findOrFail($id);
        else $DynamicModel = Representative::with('Files')->withoutGlobalScope(new ApprovedScope)->find($id);
        $Files = clientsFile::where('fileable_id' , $id)->get();
    //    dd($DynamicModel);
        return view('clients.attachments' , compact('Files', 'DynamicModel', 'type'));
    }

    public function download($id){
        try {
            // return $id;
            $File  = clientsFile::find($id);
            $StringExploded = explode( '/', $File->file);
            $LastIndex = count($StringExploded) - 1;
            $FileName = ($StringExploded[$LastIndex]);
            $path = public_path($File->file);
            $headers = ['Content-Type: image/jpeg'];
            return response()->download($path, $FileName, $headers);
        } catch (Exception $e) {
            return $e;
            return redirect()->back();
        }



    }

    public function ShowFile($id){
        $FileName = clientsFile::find($id)->file;
         $pathToFile = Storage::disk('public')->getAdapter()->applyPathPrefix( '../'.$FileName);
        return response()->file($pathToFile);
    }
}
