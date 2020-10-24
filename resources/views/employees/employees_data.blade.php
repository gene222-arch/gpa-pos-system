<table class="table table-striped table-responsive">

    <thead class="table-header">
        <tr class="table-col-name">
            <th>Firstname</th>
            <th>Lastname</th>
            <th>Avatar</th>
            <th>Email</th>
            <th>Phone</th>
            <th>Salary</th>
            <th>Commission</th>
            <th colspan="3" class="employees-actions">Actions</th>
        </tr>
    </thead>

    <tbody>
        @foreach ($employees as $employee)

            <tr class="employee__data__{{ $employee->id }}">
                
                <td class="first-name-{{ $employee->id }}">{{ $employee->first_name }}</td>
                <td class="last-name-{{ $employee->id }}">{{ $employee->last_name }}</td>
                <td class="avatar-{{ $employee->id }}">
                    <img src="{{ asset('storage/employees/avatars/' . $employee->avatar ) }}" alt="">
                </td>
                <td class="email-{{ $employee->id }}">{{ $employee->email }}</td>
                <td class="phone-{{ $employee->id }}">{{ $employee->phone }}</td>
                <td class="salary-{{ $employee->id }}">{{ $employee->salary }}</td>
                <td class="commission-{{ $employee->id }}">{{ $employee->commission }}</td>

                <td class="read">
                    <a data-target="#showEmployeeModal" data-toggle="modal" class="btn btn-info show-employee show-employee{{ $employee->id }}" id="{{ $employee->id }}">
                        <i class="far fa-eye"></i>
                    </a>
                </td>

                <td class="edit">
                    <a data-target="#editEmployeeModal" data-toggle="modal" class="btn btn-warning edit-employee edit-employee{{ $employee->id }}" id="{{ $employee->id }}">
                        <i class="far fa-edit"></i>
                    </a>
                </td>

                <td class="delete">
                    <a class="btn btn-danger destroy-employee " id="{{ $employee->id }}"> 
                        <i class="far fa-trash-alt"></i>
                    </a>
                </td> 
                <td>
                    <a href="/admin/employee/employee-data-to-word/{{ $employee->id }}" class="btn btn-primary">CV</a>
                </td>

            </tr>

        @endforeach
    </tbody>

</table>

@if (!count($employees))
    <img src="{{ asset('storage/table/empty_data.png') }}" alt="">
@endif

<div class="employees-page-link">{{ $employees->render() }}</div>
