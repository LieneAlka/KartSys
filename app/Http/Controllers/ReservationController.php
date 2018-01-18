<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Reservation;
use Auth;
use Validator;
Use DB;

class ReservationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $reservations = DB::table('reservations')
                        ->orderBy('date','desc')
                        ->get();

        $users = DB::table('users')
                ->orderBy('id','desc')
                ->get();

        return view('reservations.index', compact('reservations', 'users'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $edit = false;

        return view('reservations.addRes', compact('edit'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    public function store(Request $request)
    {

        $messages = [ //messages to show on specific errors

            'required' => 'This field is required',
            'unique' => 'This date or time is already taken',
            'integer' => 'This field must be an integer',
            'max' => 'Entered value contains too many simbols',
            'min' => 'Entered value is too small'
        ];

        $resDb = new Reservation; //database object or something

        $resDb->first_name = request('first_name');
        $resDb->last_name = request('last_name');
        $resDb->number = request('number');
        $resDb->date = request('date');
        $resDb->hours = request('hours');
        $resDb->minutes = request('minutes');
        $resDb->length = request('length');
        $resDb->numberRiders = request('numberRiders');
        $resDb->employee_id = Auth::user()->id;

        $resDb->save(); //save data to database

        $reservations = DB::table('reservations')
                        ->orderBy('id','desc')
                        ->get();

        $times = DB::table('reservations')->
                where('date', '=', request('date'))->
                where('hours', '=', request('hours'))->
                where('minutes', '=', request('minutes'))->
                get();
          
        if ( !$times->isEmpty() ) {
            $timeVal = 'required|unique:reservations';
        }
        else $timeVal = 'required';

        $rules = [ // validation rules
            'first_name' => 'required|max:100|string',
            'last_name' => 'required|max:100|string',
            'number' => 'required|min:20000000|max:29999999|integer',
            'date' => $timeVal,
            'hours' => $timeVal,
            'minutes' => $timeVal,
            'length' => 'required',
            'numberRiders' => 'required|integer'
        ];

        $validator = Validator::make($request->all(), $rules, $messages);
        $validator->validate(); //Validates entered data

        

        return view('reservations.index', compact('reservations')); //vēl jāuztaisa fails
                        

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Reservation $reservation)
    {
        $edit = true;

        return view('reservations.addRes', compact('edit','reservation'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Reservation $reservation)
    {
        

        $messages = [ //messages to show on specific errors

            'required' => 'This field is required',
            'integer' => 'This field must be an integer',
            'max' => 'Entered value contains too many simbols',
            'min' => 'Entered value is too small',
            'unique' => 'This date and time is already taken',
        ];

        $reservation->first_name = request('first_name');
        $reservation->last_name = request('last_name');
        $reservation->number = request('number');
        $reservation->date = request('date');
        $reservation->hours = request('hours');
        $reservation->minutes = request('minutes');
        $reservation->length = request('length');
        $reservation->numberRiders = request('numberRiders');

        $reservation->save();

        $time = DB::table('reservations')->
                where('date', '=', request('date'))->
                where('hours', '=', request('hours'))->
                where('minutes', '=', request('minutes'))->
                get();
                

        if ( !$time->isEmpty()) {
            $timeVal = 'required|unique:reservations';
        }
        else {
            $timeVal = 'required|date';
        }


        $rules = [ // validation rules
            'first_name' => 'required|max:100|string',
            'last_name' => 'required|max:100|string',
            'number' => 'required|min:20000000|max:29999999|integer',
            'date' => $timeVal,
            'hours' => $timeVal,
            'minutes' => $timeVal,
            'length' => 'required',
            'numberRiders' => 'required|integer'
        ];

        $validator = Validator::make($request->all(), $rules, $messages);
        $validator->validate(); //Validates entered data

        
          
        

        return redirect()->route('reservIndex');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $reservation = Reservation::find($id);
        $reservation->delete();

        $reservation = \App\Reservation::all();

        return back(); //redirect()->route('view-users', $users);
    }
}
