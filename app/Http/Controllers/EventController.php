<?php

namespace App\Http\Controllers;

use App\Models\Group;
use App\Models\Event;
use App\Models\Member;
use App\Http\Requests\EventRequest;
//use Illuminate\Http\Request;

class EventController extends Controller
{
    
    /*public function index(Event $event)
    {
        return view('events.index')->with(['events' => $event->get()]);  
    }*/
    
    public function create(Group $group)
    {
        return view('events.create')->with(['group' => $group]);
    }
    
    public function store(Event $event, EventRequest $request)
    {
        $input = $request['event'];
        $event->fill($input)->save();
        //$members = Member::where('group_id', $event->group_id)->get();
        //return view('member_event_pays.create', compact('event','members'));
        return redirect('/member_event_pays/create/events/'. $event->id);
    }
    
    public function edit(Event $event)
    {
        //return view('events.edit', compact('group', 'events'));
        return view('events.edit')->with(['event' => $event]);
    }
    
    public function update(Event $event, EventRequest $request)
    {
        $input_event = $request['event'];
        $event->fill($input_event)->save();
        return redirect('/groups/'. $event->group->id);
    }
}
