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
        
        $users = User::all();
        foreach($input_members as $input_member){
            $member = new Member();
            $member->group_id = $group->id;
            $member->user_id = $input_member;
            $member->lend = 0.00;
            $member->borrow = 0.00;
            foreach($users as $user){
                if($input_member == $user->id){
                    $member->name = $user->name;
                    break 1;
                }
            }
            $member->save();
        }
        return redirect('/groups/' . $group->id);
        
    }
    
    public function edit(Group $group,)
    {
        $members = Member::where('group_id', $group->id)->get();
        return view('groups.edit', compact('members','group'));
    }
    
    public function update(GroupRequest $request, Group $group)
    {
        $input_group = $request['group'];
        $group->fill($input_group)->save();
        /*
        //group編集画面でメンバーを追加、削除できるようにするか(memberテーブルにdelete_atなし)
        $input_members = $request->users_array;
        $members = Member::where('group_id', $group->id)->get();
        foreach($members as $member){
            if(!(in_array($member->user_id, $input_members))){
                $member->delete();
            }
        }
        $add_members = array_diff($input_members, $members->user_id); //新たに追加するメンバー
        $add_members = array_values($add_members); //indexを詰める
        
        $users = User::all();
        foreach($add_members as $add_member){
            $member = new Member();
            $member->group_id = $group->id;
            $member->user_id = $add_member;
            $member->lend = 0.00;
            $member->borrow = 0.00;
            foreach($users as $user){
                if($add_member == $user->id){
                    $member->name = $user->name;
                    break 1;
                }
            }
            $member->save();
        }
        */
        return redirect('/home');
    }
}
