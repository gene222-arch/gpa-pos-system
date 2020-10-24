<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\CustomerUpdateRequest;
use App\Http\Requests\CustomerStoreRequest;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;
use App\Models\Customer;

class CustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {   

        if ($request->wantsJson()) {

            return response(
                DB::table('customers')->get()
            );
        }

        return view('customers.index', ['customers' => DB::table('customers')->latest()->paginate(5)]);
    }

    public function getMoreCustomers () 
    {
        return view('customers.customer_data', ['customers' => DB::table('customers')->latest()->paginate(5)])->render();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('customers.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CustomerStoreRequest $request)
    {

        $avatar = $this->upload($request, null, 'store');
        $isInserted = DB::table('customers')->insert([
            'avatar' => $avatar,
            'user_id' => 1,
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'email' => $request->email,
            'address' => $request->address
        ]);

        if (!$isInserted) {

            return redirect()->back()->with('error', 'Error');
        }

        return redirect()->route('customers.index')->with('success', 'Success');

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id, Request $request)
    {
        if ( $request->ajax() ) {

            return response()->json(['customer' => DB::table('customers')->find($id)]);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(CustomerUpdateRequest $request, $id)
    {   

        $avatar = $this->upload($request, $id, 'update');
        $isUpdated = DB::table('customers')
            ->where('id', $id)
            ->update([
                'avatar' => $avatar,
                'first_name' => $request->first_name,
                'last_name' => $request->last_name,
                'email' => $request->email,
                'address' => $request->address
                ]);

        return response()->json([
            'action' => $isUpdated ? 'Updated!' : '',
            'messageOnUpdate' => $isUpdated ? 'Customer data has been updated.' : '',
            'status' => 'success',
            'data' => \App\Models\Customer::find($id) 
            ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {   

        Storage::delete('public/customers/avatars/' . Customer::find($id)->avatar);
        $isDeleted = DB::table('customers')
                        ->where('id', '=', $id)
                        ->delete();

        $swalMessage = [
            'action' => $isDeleted ? 'Deleted!' : '',
            'messageOnDelete' => $isDeleted ? 'Customer data has been deleted.' : 'There was an error in the System',
            'status' => $isDeleted  ? 'success' : ''
        ];

        return response()->json($swalMessage);
    }

    public function upload (Request $request, $id = null, $action) 
    {

        $customer = Customer::find($id);
        $file = $request->file('avatar');
    
    // File empty
        if ( $action == 'store' && !$request->has('avatar')) {

            return 'no_image.png';
        }
    // File !empty
        if ( $action == 'update' && $request->has('avatar')) {

            Storage::delete('public/customers/avatar/' . $customer->avatar);
        }

        if ( $request->has('avatar') ) {

            $fullFileName = $file->getClientOriginalName();
            $fileName = \pathinfo($fullFileName, PATHINFO_FILENAME);
            $fileExtension = $file->extension();
            $newUniqueFileName = $fileName . '_' . time() . '.' . $fileExtension; 
            $pathToStore = $file->storeAs('public/customers/avatars/', $newUniqueFileName);

            return $newUniqueFileName;
        } 

        return $customer->avatar;
    }


}

