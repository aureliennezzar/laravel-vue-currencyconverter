<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Currency;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;

class CurrencyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $currencies = Currency::all();
        return response()->json($currencies);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'name' => 'required|max:3',
        ]);

        if($validator->fails()){
            return response()->json(['message'=>'Validation Failed','errors' => $validator->errors()], 400);
        }



        $newCurrency = new Currency([
            'name' => $request->get('name'),
        ]);

        $newCurrency->save();

        return response()->json($newCurrency);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $currency = Currency::findOrFail($id);
        return response()->json($currency);
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
        $currency = Currency::findOrFail($id);

        $request->validate([
            'name' => 'required|max:3',
        ]);

        $currency->name = $request->get('name');
        $currency->save();

        return response()->json($currency);
    }
//
//    api/convert?from=USD&to=EUR&amount=10
// [EUR,USD]
// EURUSD -> name
//WHERE primary_devise equal arr[0] && WHERE secondary_devise equal arr[1]
//


//
//


    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {

        $currency = Currency::findOrFail($id);
        $currency->delete();

        return response()->json($currency::all());
    }
}
