<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Conversion;
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
            $pair["primary_currency"] = Currency::where("name", $pair["primary_currency"])->get();
            $pair["secondary_currency"] = Currency::where("name", $pair["secondary_currency"])->get();
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
        $conversion = new Conversion([
            "pair" => $pair[0]->id,
        ]);
        $conversion->save();
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
            "from" => Currency::where('name', $from)->get(),
            "to" => Currency::where('name', $to)->get(),
            "rate" => $rate,
            "result" => $result
        ]);
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'rate' => 'required|max:200',
        ]);

        $newPair = new Pair([
            'primary_currency' => $request->get('primary_currency'),
            'secondary_currency' => $request->get('secondary_currency'),
            'rate' => $request->get('rate'),
        ]);

        $newPair->save();
        return response()->json($newPair);
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $pair = Pair::findOrFail($id);
        return response()->json($pair);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $pair = Pair::findOrFail($id);

        $request->validate([
            'rate' => 'required|max:200',
        ]);

        $pair->primary_currency = $request->get('primary_currency');
        $pair->secondary_currency = $request->get('secondary_currency');
        $pair->rate = $request->get('rate');
        $pair->save();
        return response()->json($pair);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */

    public function destroy($id)
    {
        $pair = Pair::findOrFail($id);
        $pair->delete();

        return response()->json($pair::all());
    }
}
