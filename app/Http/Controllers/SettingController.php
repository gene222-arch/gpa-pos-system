<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\SettingRequest;
use App\Models\Settings;
use Illuminate\Support\Facades\DB;


class SettingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('settings.edit');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(SettingRequest $request)
    {   

        foreach ($request->except('_token') as $key => $value) {
            $settings = $this->firstOrCreate($key, $value);
        }
        return redirect()->route('settings.index');
    }

    public function firstOrCreate ($key, $value) 
    {

        $notExists = DB::table('settings')->where('key', '=', $key)->doesntExist();

        if ( $notExists ) {

            DB::table('settings')->insert(['key' => $key, 'value' => $value]);
        }

        DB::table('settings')
            ->where('key', '=', $key)
            ->update([
                'value' => $value
            ]);

    }


}
