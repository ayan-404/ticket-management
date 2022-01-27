<?php

namespace App\Http\Controllers;

use App\Models\Ticket;
use Carbon\Carbon;
use Illuminate\Http\Request;

class TicketController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, Ticket $ticket)
    {
        if ($request->isMethod('GET')) {
            $tickets = Ticket::all();
            return view(
                'dashboard',
            )->with('tickets', $tickets);
        } else {
            $input = $request->all();
            Ticket::create($input);
            return redirect('/dashboard')
                ->with('success', 'Ticket Added Successfully');
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view(
            'create'
        );
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $input = $request->all();
        Ticket::create($input);
        return redirect('/dashboard')
            ->with('success', 'Ticket Added Successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $tickets = Ticket::find($id);
        return view(
            'show'
        )->with('tickets', $tickets);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $ticket = Ticket::find($id);
        return view(
            'edit'
        )->with('ticket', $ticket);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $ticket = Ticket::find($id);
        $input = $request->all();
        $ticket->update($input);
        return redirect('/dashboard')->with('success', 'Ticket Updated!');  
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Contact  $contact
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Ticket::destroy($id);
        return redirect('/dashboard')
                ->with('flash_message', 'Ticket deleted!');  
    }

    /**
     * Show the form for Checking out the specified ticket
     * 
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    public function checkoutPage($id)
    {
        $ticket = Ticket::find($id);
        $dt = Carbon::now();
        $made_time = Carbon::parse($ticket->created_at);
        $difference = $made_time->diffInMinutes($dt, false);
        if ($difference > 60) {
            $price = ($difference * 0.16) * 15.42;
        } elseif ($difference <= 60) {
            $price = ($difference * 0.16) * 15.42 - 10 ;
        }
        return view(
            'checkout'
        )->with('ticket', $ticket)->with('price', $price)->with('dt', $dt)->with('diff', $difference);
    }

    /**
     * Checkout the specified resource in storage.
     * And update status and disable any actions to it in the UI.
     * 
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function checkout(Request $request, $id)
    {
        $ticket = Ticket::find($id);
        $input = $request->all();
        $ticket->update($input);
        return redirect('/dashboard')->with('success', 'Ticket Checked out successfuly');
    }

}
