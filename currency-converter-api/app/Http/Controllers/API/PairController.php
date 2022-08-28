<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Currency;
use App\Models\Pair;
use Illuminate\Http\Request;

class PairController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $pairs = Pair::all();
        foreach ($pairs as $pair) {
            $pair["primary_currency"] = Currency::where("id",$pair["primary_currency"])->get();
            $pair["secondary_currency"] = Currency::where("id",$pair["secondary_currency"])->get();
        }
        return response()->json($pairs);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function convert(Request $request, $from, $to, $amount)
    {
        $duo = [$from, $to];

        usort($duo, function ($a, $b) {
            return strcmp($a, $b);
        });
        $pair = Pair::where('primary_currency', $duo[0])->where('secondary_currency', $duo[1])->get();
        $rate = $pair[0]->rate;
        $reversed = false;
        if ($from != $duo[0]) {
            // Secondary -> Primary
            $rate = 1 / $rate;
            $reversed = true;
        }

        $result = $rate * $amount;

        $pair[0]->reversed = $reversed;
        $pair[0]->result = $result;
        return response()->json([
            "from" => Currency::where('name',$from)->get(),
            "to" => Currency::where('name',$to)->get(),
            "rate" => $rate,
            "result" => $result
        ]);
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Models\Pair $pair
     * @return \Illuminate\Http\Response
     */
    public function show(Pair $pair)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Models\Pair $pair
     * @return \Illuminate\Http\Response
     */
    public function edit(Pair $pair)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Pair $pair
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Pair $pair)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    public function destroy($id)
    {
        $pair = Pair::findOrFail($id);
        $pair->delete();

        return response()->json($pair::all());
    }
}
