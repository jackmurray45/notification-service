<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Notification;
use App\Http\Requests\StoreNotification;
use App\Events\NotificationCreated;

class NotificationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->authorize('Read Notifications');
        return Notification::paginate(50);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreNotification $request)
    {
        $this->authorize('Create Notifications');

        $data = $request->validated();
        $data['recipients'] = implode(',', $data['recipients']);
        $data['token_id'] = $request->user()->id;
        $data['status'] = 'pending';

        $notification = Notification::create($data);

        event(new NotificationCreated($notification));
        
        return $notification->unsetRelation('notificationLogs');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, Notification $notification)
    {
        $this->authorize('Read Notifications');

        if($request->logs == 1)
        {
            $notification->notificationLogs;
        }

        return $notification;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Notification $notification)
    {
        $this->authorize('Delete Notifications');

        $notification->delete();

        return response(null, 204);


    }
}
