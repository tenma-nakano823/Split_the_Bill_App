<?php

namespace App\Http\Controllers;

use App\Models\Group;
use App\Models\Event;
use App\Models\Member;
use App\Models\MemberEventPay;
use App\Models\MemberEventPaid;
use App\Http\Requests\EventRequest;
use App\Http\Requests\MemberEventPayRequest;
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
        $members = Member::where('group_id', $event->group_id)->get();
        $memberEventPays = [];
        $memberEventPaids = [];
        $isChecked = false;
        $isCheckeds = [];
                
        foreach ($members as $member) {
            $memberEventPay = MemberEventPay::where('event_id', $event->id)->where('member_id', $member->id)->first();
            $memberEventPaid = MemberEventPaid::where('event_id', $event->id)->where('member_id', $member->id)->first();
            if ($memberEventPay) {
                array_push($memberEventPays, $memberEventPay);
            }
            if ($memberEventPaid) {
                array_push($memberEventPaids, $memberEventPaid);
                array_push($isCheckeds, true);
            } else {
                array_push($isCheckeds, false);
            }
        }
        return view('events.edit', compact('members','event','memberEventPays','memberEventPaids','isCheckeds'));
        //return view('events.edit')
    }
    
    public function edit1(Event $event)
    {
        //return view('events.edit', compact('group', 'events'));
        $group = Group::where('id', $event->group_id)->first();
        $members = Member::where('group_id', $event->group_id)->get();
        $member_event_pays = MemberEventPay::where('event_id', $event->id)->get();
        $member_event_paids = MemberEventPaid::where('event_id', $event->id)->get();
        return view('events.edit', compact('event','group','members','member_event_pays','member_event_paids'));
    }
    
    public function update(Event $event, MemberEventPay $member_event_pay, MemberEventPaid $member_event_paid, EventRequest $eventRequest, MemberEventPayRequest $membereventpayRequest)
    {
        $memberId = [];
        
        $input_group_id = $eventRequest->group_id;
        $input = $membereventpayRequest['member_event_pay'];
        $input_member_event_pays = $membereventpayRequest->member_event_pays_array;
        foreach($input_member_event_pays as $input_member_event_pay)
        {
            $member_event_pay = MemberEventPay::where('event_id', $event->id)->where('member_id', $input_member_event_pay['member_id'])->first();
            if (!$input_member_event_pay['amount']){
                $input_member_event_pay['amount'] = 0;
            }
            $member_event_pay->amount = $input_member_event_pay['amount'];
            $member_event_pay->save();
        }
        
        //member_event_paisについて
        $input_member_event_paids = $membereventpayRequest->member_event_paids_array;
        $member_event_paids = MemberEventPaid::where('event_id', $event->id)->get();
        foreach($member_event_paids as $member_event_paid){
            array_push($memberId, $member_event_paid->member_id);
            if(!(in_array($member_event_paid->member_id, $input_member_event_paids))){
                $member_event_paid->delete();
            }
        }
        
        $add_member_event_paids = array_diff($input_member_event_paids, $memberId); //新たに追加するメンバー
        $add_member_event_paids = array_values($add_member_event_paids); //indexを詰める
        
        foreach($add_member_event_paids as $add_member_event_paid)
        {
            $member_event_paid = new MemberEventPaid();
            $member_event_paid->event_id = $input["event_id"];
            $member_event_paid->member_id = $add_member_event_paid;
            $member_event_paid->save();
        }
        return redirect('/groups/'. $input_group_id);
        /*
        //eventについて
        $input_event = $eventRequest['event'];
        $event->fill($input_event)->save();
        
        //member_event_payについて
        $input_event_id = $membereventpayRequest['member_event_pay'];//event_id保存用
        $input_member_event_pays = $membereventpayRequest->member_event_pays_array;
        
        foreach($input_member_event_pays as $input_member_event_pay)
        {
            if (!$input_member_event_pay['amount']){
                $input_member_event_pay['amount'] = 0;
            }
            $member_event_pay = MemberEventPay::where('event_id', $event->id)->where('member_id',$input_member_event_pay['member_id'])->get();
            $member_event_pay->event_id = $input_event_id['event_id'];
            $member_event_pay->member_id = $input_member_event_pay['member_id'];
            $member_event_pay->amount = $input_member_event_pay['amount'];
            $member_event_pay->save();
        }
        
        //member_event_paisについて
        $input_member_event_paids = $membereventpayRequest->member_event_paids_array;
        $member_event_paids = MemberEventPaids::where('event_id', $event->id)->get();
        foreach($member_event_paids as $member_event_paid){
            if(!(in_array($member_event_paid->member_id, $input_member_event_paids))){
                $member_event_paid->delete();
            }
        }
        
        $add_member_event_paids = array_diff($input_member_event_paids, $member_event_paids->user_id); //新たに追加するメンバー
        $add_member_event_paids = array_values($add_member_event_paids); //indexを詰める
        
        foreach($add_member_event_paid as $add_member_event_paids)
        {
            $member_event_paid = new MemberEventPaid();
            $member_event_paid->event_id = $input_event_id["event_id"];
            $member_event_paid->member_id = $add_member_event_paids;
            $member_event_paid->save();
        }
        
        return redirect('/groups/'. $event->group->id);
        */
    }
}
