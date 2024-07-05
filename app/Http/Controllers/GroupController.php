<?php

namespace App\Http\Controllers;

use App\Models\Group;
use App\Models\Event;
use App\Models\User;
use App\Models\Member;
use App\Models\MemberEventPay;
use App\Models\MemberEventPaid;
use App\Http\Requests\GroupRequest;
use App\Http\Requests\SearchRequest;
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
        
        $groups = $groups->sortByDesc('updated_at');
        $users = User::all();
        return view('groups.index', compact('users','groups'));
    }
    
    public function search(SearchRequest $request)
    {
        $query = $request->input('query');
        $selectedUserIds = $request->input('selected_user_ids', []);
    
        $users = User::where('name', 'LIKE', "%{$query}%")
                    ->whereNotIn('id', $selectedUserIds)
                    ->get();
    
        $results = '<div class="flex flex-wrap">';
        foreach ($users as $user) {
            $results .= '<div class="bg-white  text-blue-500 border-2 border-blue-500 mx-auto rounded px-4 py-2 text-xl text-center"><a href="#" class="add-user" style="font-size: 20px; font-weight: 500;" data-id="' . $user->id . '" data-name="' . $user->name . '">' . $user->name . '</a></div>';
        }
        $results .= '</div>';
    
        return response()->json($results);
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
        $events = $group->getByGroup();
        
        //lendについて
        $members = $group->members;
        foreach($members as $member){
            $member->lend = 0;
            $member->borrow = 0;
        }
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
        
        //borrowについて
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
                            if($member_event_paid->is_fraction_adjust){//端数調整
                                $member->borrow += $extra;
                            }
                        }
                    }
                }
            }
        }
        
        foreach($members as $member){
            $member->save();
        }
        
        $members = $group->members;
        //お金のやり取りを記録
        $nameArray = [];
        $lendborrowArray = [];
        $resultArray = [];
        
        
        foreach($members as $member){
            $nameArray[] = $member->name; //array_push()の方が処理が遅いらしい
            $calculate_money = $member->lend - $member->borrow;
            $lendborrowArray[] =$calculate_money;
        }
        //渡す人ともらう人のキーを取得
        for($i=0; $i < count($lendborrowArray);  $i++){
            if ($lendborrowArray[$i] != 0){
                for($j=$i;  $j < count($lendborrowArray);  $j++){
                    if($lendborrowArray[$j] < 0){
                        $give_key = $j;
                        break 1;
                    }
                }
                for($j=$i;  $j < count($lendborrowArray);  $j++){
                    if($lendborrowArray[$j] > 0){
                        $get_key = $j;
                        break 1;
                    }
                }
                
                if(abs($lendborrowArray[$give_key]) >= $lendborrowArray[$get_key]){
                    $move_money = $lendborrowArray[$get_key];
                    $lendborrowArray[$give_key] += $move_money;
                    $lendborrowArray[$get_key] = 0;
                } else {
                    $move_money = abs($lendborrowArray[$give_key]);
                    $lendborrowArray[$give_key] = 0;
                    $lendborrowArray[$get_key] -= $move_money;
                }
                $move_money = number_format($move_money);
                $resultArray[] = array('give_name'=>$nameArray[$give_key], 'get_name'=>$nameArray[$get_key], 'money'=>$move_money);
                $i--;
            }
        }
        
        return view('groups.show', compact('group', 'events', 'members', 'resultArray'));
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
    
    public function edit(Group $group)
    {
        $members = Member::where('group_id', $group->id)->get();
        return view('groups.edit', compact('members','group'));
    }
    
    public function update(GroupRequest $request, Group $group)
    {
        $memberId = [];
        $input_group = $request['group'];
        $group->fill($input_group)->save();
        
        //group編集画面でメンバーを追加、削除できるようにする
        $input_members = $request->users_array;
        $members = Member::where('group_id', $group->id)->get();
        foreach($members as $member){
            array_push($memberId, $member->user_id);
            if(!(in_array($member->user_id, $input_members))){
                $events = Event::where('group_id', $member->group_id)->get();
                foreach($events as $event){
                    $member_event_pays = MemberEventPay::where('event_id', $event->id)->get();
                    $member_event_paids = MemberEventPaid::where('event_id', $event->id)->get();
                    foreach($member_event_pays as $member_event_pay){
                        $member_event_pay->delete();
                    }
                    foreach($member_event_paids as $member_event_paid){
                        $member_event_paid->delete();
                    }
                    $event->delete();
                }
                $member->delete();
            }
        }
        $add_members = array_diff($input_members, $memberId); //新たに追加するメンバー
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
        
        return redirect('/home');
    }
    
    public function delete(Group $group)
    {
        $group->delete();
        return redirect('/home');
    }
}
