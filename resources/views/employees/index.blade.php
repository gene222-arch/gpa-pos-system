@extends('layouts.admin')

@section('title', 'Employees')

@section('css')
    <style>
        
        .employee__avatar__container {
            display: flex;
            justify-content: center;
            align-items: center;
            margin: 0 0 1rem;
        }

        .employees-page-link {
            margin: 1rem 0 0;
        }

        .employees-actions {
            text-align: center
        }

        #searchEmployeeForm .search-form-components {
            margin: 0 .25rem 1rem;
        }

    </style>
@endsection

@section('content-header', 'Employees')

{{-- Page Content Actions --}}
@section('content-actions')
    <a data-target="#createEmployeeModal" data-toggle="modal" class="btn btn-success create-employee">
        <i class="fas fa-user-plus fa-2x p-1"></i>
    </a>
@endsection

@section('content')

    <div class="show__employee__data">
        @include('employees.modal.show')
    </div>

    <div class="add__employee__data">
        @include('employees.modal.create')
    </div>

    <div class="edit__employee__data">
        @include('employees.modal.edit')
    </div>

    <div class="search-form">
        <form class="form-inline mb-2 my-lg-0" id="searchEmployeeForm">
            <div class="search-form-components row">
                <div class="col-md-1">
                    <label for="searchEmployee">Search: </label>
                </div>
                <div class="col-md-10">
                    <input class="form-control mr-sm-2 search-employee" name="searchEmployee" type="search" placeholder="Search" aria-label="Search">
                </div>
            </div>
        </form>
    </div>
    <div class="employee-data container-fluid">
        @include('employees.employees_data')
    </div>

@endsection

@section('js')
    <script src="{{ asset('js/employeesScript/employees.js') }}"></script>
@endsection