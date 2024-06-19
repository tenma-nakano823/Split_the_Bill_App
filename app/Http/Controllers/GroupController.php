<?php

namespace App\Http\Controllers;

use App\Models\Group;
use App\Models\Event;
use App\Models\User;
use App\Models\Member;
use App\Http\Requests\GroupRequest;
use Illuminate\Support\Facades\Auth;
//use Illuminate\Http\Request;

class GroupController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $members = Member::where('user_id', $user->id)->get();
        $groups = collect();
        foreach($members as $member){
            $group = Group::find($member->group_id);
            if($group){
                $groups->push($group);
            }
        }
        $users = User::all();
        return view('groups.index', compact('users','groups'));
        //return view('groups.index')->with(['groups' => $groups]);  
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
    
    public function create(User $user)
    {
        return view('groups.create')->with(['users' => $user->get()]);
    }
    
    public function store(Group $group, GroupRequest $request)
    {
        
        $input = $request['group'];
        $input_members = $request->users_array;
        $group->fill($input)->save();
        foreach($input_members as $input_member){
            $member = new Member();
            $member->group_id = $group->id;
            $member->user_id = $input_member;
            $member->lend = 0.00;
            $member->borrow = 0.00;
            $member->save();
        }
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
