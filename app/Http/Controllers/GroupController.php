<?php

namespace App\Http\Controllers;

use App\Models\Group;
use App\Models\Event;
use App\Models\User;
use App\Models\Member;
use App\Models\MemberEventPay;
use App\Models\MemberEventPaid;
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
        
        //lend
        $members = $group->members;
        foreach($members as $member){
            $sum_lend = 0;
            $member_event_pays = MemberEventPay::where('member_id', $member->id)->get();
            if($member_event_pays->count()){
                foreach($member_event_pays as $member_event_pay){
                    $sum_lend += $member_event_pay->amount;
                }
            $member->lend = $sum_lend;
            }
        }
        
        //borrow
        foreach($members as $member){
            $member->borrow = 0;
        }
        foreach($events as $event){
            $sum_amount = 0;
            $count_member = 0;
            $member_event_pays = MemberEventPay::where('event_id', $event->id)->get();
            if($member_event_pays->count()){
                foreach($member_event_pays as $member_event_pay){
                    $sum_amount += $member_event_pay->amount;
                }
                $member_event_paids = MemberEventPaid::where('event_id', $event->id)->get();
                $count_member = $member_event_paids->count();
                $extra = $sum_amount % $count_member;
                foreach($member_event_paids as $member_event_paid){
                    foreach($members as $member){
                        if($member_event_paid->member_id == $member->id){
                            $member->borrow += floor($sum_amount / $count_member);
                        }
                        if($extra != 0){
                            $member->borrow += $extra;
                            $extra = 0;
                        }
                    }
                }
            }
        }
        foreach($members as $member){
            $member->save();
        }
        
        $members = $group->members;
        return view('groups.show', compact('group', 'events', 'members'));
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
