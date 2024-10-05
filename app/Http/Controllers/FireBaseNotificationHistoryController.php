<?php

namespace App\Http\Controllers;

use App\Models\Area;
use App\Models\FireBaseNotificationHistory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Broadcast;
use Illuminate\Support\Facades\Validator;
use App\Events\BordcastToAllRepresetitve;
use App\Events\SendNotifcationWithFireBase;
use App\Models\Client;
use App\Models\Representative;
use Exception;

class FireBaseNotificationHistoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $Notification = FireBaseNotificationHistory::with('Area')->orderBy('created_at' , 'DESC')->paginate(10);
        return view('notification.index', compact('Notification'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $Area = Area::get();
        return view('notification.create', compact('Area'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try {
            // return $request;
            $Validator =  Validator::make($request->all(), [
                'title' => 'required',
                'content' => 'required',
                // 'type' => 'required',
                'area_id' => 'required',
                'user_id' => 'required_if:ToSpicficUser,on',
                // 'ToSpicficUser' => 'nullable',
            ]);
            if ($Validator->fails()) return redirect()->back()->withErrors($Validator->errors());
            // Init Value To FileNmae Vairble
            $fileName = null;
            // Check if Exist  And Upload The Image
            if($request->has('photo')){
                $fileName = $request->photo->getClientOriginalName();
                $request->photo->move(public_path('uploads/notification'), $fileName);
            }
            if ($request->to == 1) {
                $type = $topic = 'client';
                if($request->area_id !== 'all') $topic = 'client.' . $request->area_id;
            } else {
                $topic = 'representative';
                if($request->area_id  !== 'all') $topic = 'representative.' . $request->area_id;
                $type = 'representative';
            }
            // Check If The Notification Send TO Spicefic User
            $User = $request->user_id ? $request->user_id : null;
            $FireBase = FireBaseNotificationHistory::create([
                'title' => $request->title,
                'notifcation' => $request->content,
                'type' => $type,
                'area_id' => $request->area_id ,
                'user_id' => $User ,
                'image' => $fileName,
                'topic' => $topic ,
            ]);
            // fire Event With User Token   ---------------------
            if($request->ToSpicficUser){
                if ($request->to == 1) $MessageToken = Client::find($request->user_id)->message_token;
                if ($request->to == 2) $MessageToken = Representative::find($request->user_id)->message_token;
                event(new  SendNotifcationWithFireBase($MessageToken , $request->title ,$request->content,  asset('uploads/notification/' .$fileName) ,  null ));
                session()->flash('success', __('translation.notifcation.send.successfuly'));
                return redirect()->route('notification.index');
            }
            // fire To All Representive
            event(new BordcastToAllRepresetitve($topic , $request->title , $request->content, asset('uploads/notification/' .$fileName)));
            session()->flash('success', __('translation.notifcation.send.successfuly'));
            return redirect()->route('notification.index');
        } catch (Exception $e) {
            // return $e;
            session()->flash('error', __('translation.exception.error'));
            return redirect()->back();
            return $e;
        }
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\FireBaseNotificationHistory  $fireBaseNotificationHistory
     * @return \Illuminate\Http\Response
     */
    public function edit($Id)
    {
        try{

        $FireBase = FireBaseNotificationHistory::find($Id);
        //  Get Orignal Image Value To Check How I Can Send The Notification
        $fileName = $FireBase->getRawOriginal('image');
        // Send To Spcific User Condtion
        if($FireBase->user_id !== null){
            // get Message Token Based On Notification Type
            if ($FireBase->type == 'client') $MessageToken = Client::find($FireBase->user_id)->message_token;
            if ($FireBase->type == 'representative') $MessageToken = Representative::find($FireBase->user_id)->message_token;
            // Fire Event With Out Image
            if($fileName) event(new  SendNotifcationWithFireBase($MessageToken , $FireBase->title ,$FireBase->notifcation , $FireBase->image));
            else event(new  SendNotifcationWithFireBase($MessageToken , $FireBase->title ,$FireBase->notifcation));
            // End The Function And Add Seetion Success
            session()->flash('success', __('translation.notifcation.resend.successfuly'));
            return redirect()->route('notification.index');
        }
        // Check If File name Is not Empty To Perform Event
        if($fileName) event(new BordcastToAllRepresetitve($FireBase->topic, $FireBase->title , $FireBase->notifcation, $FireBase->image));
        else event(new BordcastToAllRepresetitve($FireBase->topic, $FireBase->title , $FireBase->notifcation , $FireBase->fileName));
        // Return Redirect To Back User                           -------------------
        session()->flash('success', __('translation.notifcation.resend.successfuly'));
        return redirect()->back();
        }catch(Exception $e){
            session()->flash('success', __('translation.exception.error'));
            return redirect()->back();
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\FireBaseNotificationHistory  $fireBaseNotificationHistory
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $FireBase =  FireBaseNotificationHistory::find($id)->delete();
        return redirect()->back();
    }
}
