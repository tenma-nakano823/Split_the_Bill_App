<?php

namespace App\Http\Controllers;

use App\Models\Group;
use App\Models\Event;
use App\Http\Requests\GroupRequest;
//use Illuminate\Http\Request;

class GroupController extends Controller
{
    public function index(Group $group)
    {
        return view('groups.index')->with(['groups' => $group->get()]);  
    }
    
    /**
     * 特定IDのgroupを表示する
     *
     * @params Object Group // 引数の$groupはid=1のGroupインスタンス
     * @return Reposnse group view
     */
     public function show(Group $group)
    {
        //$groupWithMembers = $group->load('events');
        //return view('groups.show')->with('group', $groupWithMembers);
        $events = $group->events;
        return view('groups.show', compact('group', 'events'));
        //return view('events.index')->with(['events' => $event->get()]);
        //groups.showにしてたのを変更してみた
    }
    
    public function create()
    {
        return view('groups.create');
    }
    
    public function store(Group $group, GroupRequest $request,)
    {
        $input = $request['group'];
        $group->fill($input)->save();
        return redirect('/groups/' . $group->id);
    }
    
    public function edit(Group $group)
    {
        return view('groups.edit')->with(['group' => $group]);
    }
    
    public function update(GroupRequest $request, Group $group)
    {
        $input_group = $request['group'];
        $group->fill($input_group)->save();
    
        return redirect('/groups/' . $group->id);
    }
}
