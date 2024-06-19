<?php

namespace App\Http\Controllers;

use App\Models\Group;
use App\Models\Event;
use App\Http\Requests\EventRequest;
//use Illuminate\Http\Request;

class EventController extends Controller
{
    
    /*public function index(Event $event)
    {
        return view('events.index')->with(['events' => $event->get()]);  
    }*/
    
    public function create(Group $group, Event $event)
    {
        return view('events.create')->with(['group' => $group]);
    }
    
    public function store(Event $event, Group $group, EventRequest $request)
    {
        $input = $request['event'];
        $event->name = $input['name'];
        $event->group_id = $group->id;
        $event->save();
        return redirect('/groups/'. $group->id);
    }
    
    public function edit(Event $event, Group $group)
    {
        //return view('events.edit', compact('group', 'events'));
        return view('events.edit')->with(['event' => $event]);
    }
    
    public function update(Event $event, Group $group, EventRequest $request)
    {
        $input_event = $request['event'];
        $event->fill($input_event)->save();
        return redirect('/groups/'. $group->id);
    }
}
