<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Employee;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use PhpOffice\PhpWord\TemplateProcessor;
use App\Http\Requests\EmployeesStoreRequest;
use App\Http\Requests\EmployeeUpdateRequest;

class EmployeesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {   
        return view('employees.index', [
            'employees' => DB::table('employees')->latest()->paginate(5)
        ]);
    }

    public function getMoreEmployees (Request $request, $searchTerm = null) {

        if (! empty($searchTerm) && $request->ajax()) {
            
            return view('employees.employees_data', 
            [
                'employees' => DB::table('employees')
                    ->where('first_name', 'LIKE', '%' . $searchTerm . '%')
                    ->orWhere('last_name', 'LIKE', '%' . $searchTerm . '%')
                    ->orWhere('email', 'LIKE', '%' . $searchTerm . '%')
                    ->orWhere('employee', 'LIKE', '%' . $searchTerm . '%')
                    ->orWhere('salary', 'LIKE', '%' . $searchTerm . '%')
                    ->orWhere('commission', 'LIKE', '%' . $searchTerm . '%')
                    ->orderBy('first_name')
                    ->orderBy('last_name')
                    ->orderBy('email')
                    ->orderBy('employee')
                    ->orderBy('salary')
                    ->orderBy('commission')
                    ->latest()
                    ->paginate(5)
            ])->render();
        }

        if ($request->ajax()) {
            return view('employees.employees_data', [
                'employees' => DB::table('employees')->latest()->paginate(5)
            ])->render();
        }

        return view('employees.employees_data', [
            'employees' => DB::table('employees')->latest()->paginate(5)
        ])->render();
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(EmployeesStoreRequest $request)
    {
        $avatar = $this->upload($request, 'store');

        $isCreated = DB::table('employees')->insert([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'avatar' => $avatar,
            'email' => $request->email,
            'phone' => $request->phone,
            'salary' => $request->salary,
            'commission' => $request->commission
        ]);

        $swalMessage = [
            'action' => $isCreated ? 'Created' : '',
            'messageOnCreate' => $isCreated ? 'Employee data has been inserted.' : '',
            'statusResponse' => $isCreated ? 'success' : 'error'
        ];

        return response()->json([
            'requestResponse' => $swalMessage
        ]);
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
            return response()->json([
                'employee' => DB::table('employees')->where('id', '=', $id)->get()
            ]);
        }
    }


    public function search($searchTerm = null) 
    {

        if ( empty($searchTerm) ) {

            $search = DB::table('employees')->latest()->paginate(5);

        } else {

            $search = DB::table('employees')
                ->where('first_name', 'LIKE', '%' . $searchTerm . '%')
                ->orWhere('last_name', 'LIKE', '%' . $searchTerm . '%')
                ->orWhere('email', 'LIKE', '%' . $searchTerm . '%')
                ->orWhere('employee', 'LIKE', '%' . $searchTerm . '%')
                ->orWhere('salary', 'LIKE', '%' . $searchTerm . '%')
                ->orWhere('commission', 'LIKE', '%' . $searchTerm . '%')
                ->orderBy('first_name')
                ->orderBy('last_name')
                ->orderBy('email')
                ->orderBy('employee')
                ->orderBy('salary')
                ->orderBy('commission')
                ->paginate(5);
        }
        
        return view('employees.employees_data', [
            'employees' => $search
        ])->render();

    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(EmployeeUpdateRequest $request, $id)
    {

        $avatar = $this->upload($request, 'update', $id);

        $isUpdated = DB::table('employees')
            ->where('id', '=', $id)
            ->update([
                'first_name' => $request->first_name,
                'last_name' => $request->last_name,
                'avatar' => $avatar,
                'email' => $request->email,
                'phone' => $request->phone,
                'salary' => $request->salary,
                'commission' => $request->commission
        ]);

        $swalMessage = [
            'action' => $isUpdated ? 'Updated' : '',
            'messageOnUpdate' => $isUpdated ? 'Employee Data has been updated.' : '',
            'statusResponse' => $isUpdated ? 'success' : 'error'
        ];

        return response()->json([
            'requestResponse' => $swalMessage
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
        $employee = Employee::find($id);
        Storage::delete('public/employees/avatars/' . $employee->avatar);
        $isDeleted = $employee->delete();

        $swalMessage = [
            'action' => $isDeleted ? 'Updated' : '',
            'messageOnDelete' => $isDeleted ? 'Employee Data has been deleted.' : '',
            'statusResponse' => $isDeleted ? 'success' : 'error'
        ];

        return response()->json([
            'requestResponse' => $swalMessage
        ]);
    }

    public function upload(Request $request, $action, $id = null) {

        $file = $request->file('avatar');
        $customer = Employee::find($id);
        
        if ( $action == 'store' && !$request->has('avatar')) {

            return 'no_image.png';
        }

        if ( $action == 'update' && $request->has('avatar')) {

            Storage::delete('public/employees/avatars/' . $customer->avatar);
        }

        if ($request->has('avatar')) {

            $fileOriginalName = $file->getClientOriginalName();
            $fileName = \pathinfo($fileOriginalName, PATHINFO_FILENAME);
            $fileExtension = $file->extension();
            $newUniqueFileName = $fileName . '_' . time() . '.' . $fileExtension;
            $file->storeAs('/public/employees/avatars/', $newUniqueFileName);

            return $newUniqueFileName;
        }

        return $customer->avatar;
    }   


    /**
     * Carbon::now() is not good to use when making a filename unique because date have spaces
     */
/**
 * EXPORTS
 */
    public function employeeDataToWord($employee_id)
    {
        $employee = Employee::find($employee_id);
        
        $templateProcessor = new TemplateProcessor('storage/files/WORD/employees-resume-layout/employee.docx');
        $templateProcessor->setValue('id', $employee->id);
        $templateProcessor->setValue('employee_firstName', $employee->first_name);
        $templateProcessor->setValue('employee_lastName', $employee->last_name);
        $templateProcessor->setValue('employee_fullName', $employee->getFullName());
        $templateProcessor->setValue('employee_email', $employee->email);
        $templateProcessor->setValue('employee_phone', $employee->phone);
        $templateProcessor->setValue('employee_salary', $employee->salary);
        $templateProcessor->setValue('employee_commission', $employee->commission);
        $templateProcessor->setImageValue('photo', 
            [
                'path' => public_path('storage/employees/avatars/' . $employee->avatar), 
                'width' => 100, 
                'height' => 100, 
                'ratio' => true
            ]);
                
        $employeeFullname = str_replace(' ', '', $employee->getFullName());
        $fileName = $employeeFullname . $employee_id . '.docx';
        $filePathToSave = \public_path('storage/files/WORD/employees-resume/' . $fileName);
        $templateProcessor->saveAs($filePathToSave);
        return response()->download(\public_path('storage/files/WORD/employees-resume/' . $fileName), $fileName)->deleteFileAfterSend(false);
    }


}
