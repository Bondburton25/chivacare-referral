@extends('layouts.app')

@section('pageTitle', __('Employee profile').' '.$employee->full_name)

<style>
    .img-employee {
        width: 120px;
        height: 120px;
    }
</style>

@section('content')

<div class="container">

    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a class="link-underline-light" href="{{ route('employees.index') }}">{{ __('All employees') }}</a></li>
          <li class="breadcrumb-item active" aria-current="page">{{ __('Employee profile') }} {{ $employee->full_name }}</li>
        </ol>
    </nav>

    <div class="d-flex justify-content-between mb-3">
        <div class="page-title">
            <h1 class="h5 mnb-0">{{ __('Employee profile') }} {{ $employee->full_name }}</h1>
        </div>
        @can('isSuperAdmin')
        <div class="button-action">
            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#vertifyUser">
                {{ __('Manage permission') }} <i class="bi bi-person-fill-gear"></i>
            </button>
            <!-- Modal -->
            <div class="modal fade" id="vertifyUser" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="vertifyUserLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header border-0">
                            <h1 class="modal-title fs-5" id="vertifyUserLabel">{{ __('Manage permission') }}</h1>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>

                            <form action="{{ route('employees.update',[$employee->id]) }}" method="POST" enctype="multipart/form-data">
                                {{ method_field('PUT') }}
                                @csrf
                                <div class="modal-body text-center">

                                    <input type="radio" class="btn-check" name="role" value="admin" id="admin" autocomplete="off" checked>
                                    <label class="btn btn-outline-success me-2 px-4" for="admin">
                                        <i class="bi bi-person-fill-check h3 d-block"></i>
                                        Admin
                                    </label>
                                    <input type="radio" class="btn-check" name="role" value="operator" id="operator" autocomplete="off">
                                    <label class="btn btn-outline-warning" for="operator">
                                        <i class="bi bi-person-fill h3 d-block"></i>
                                        Operator
                                    </label>

                                    <div class="table-responsive my-4">
                                        <table class="table table-sm align-middle">
                                            <tr>
                                                <td>Permission type</td>
                                                <td>Admin</td>
                                                <td>Operator</td>
                                            </tr>
                                            <tr>
                                                <td>{{ __('View a list of all referral patients') }}</td>
                                                <td class="text-center"><i class="bi bi-check2 text-success"></i></td>
                                                <td class="text-center"><i class="bi bi-check2 text-success"></i></td>
                                            </tr>
                                            <tr>
                                                <td>{{ __('View a patient profile') }}</td>
                                                <td class="text-center"><i class="bi bi-check2 text-success"></i></td>
                                                <td class="text-center"><i class="bi bi-check2 text-success"></i></td>
                                            </tr>
                                            <tr>
                                                <td>{{ __('Update paitent stage') }}</td>
                                                <td class="text-center"><i class="bi bi-check2 text-success"></i></td>
                                                <td class="text-center"></td>
                                            </tr>
                                            <tr>
                                                <td>{{ __('Changing the expected date and time of service') }}</td>
                                                <td class="text-center"><i class="bi bi-check2 text-success"></i></td>
                                                <td class="text-center"></td>
                                            </tr>
                                            <tr>
                                                <td>{{ __('End of service') }}</td>
                                                <td class="text-center"><i class="bi bi-check2 text-success"></i></td>
                                                <td class="text-center"></td>
                                            </tr>
                                        </table>
                                    </div>
                                </div>
                                <div class="modal-footer border-0 justify-content-center d-flex">
                                    <button type="submit" class="btn btn-primary">{{ __('Confirm') }}</button>
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{ __('Close window') }}</button>
                                </div>
                            </form>
                    </div>
                </div>
            </div>
        </div>
        @endcan
    </div>

    <div class="row">
        <div class="col-md-4 col-12">
            <div class="card shadow-sm border-0 mb-3">
                <div class="card-header">{{ __('Employee information') }}</div>
                <div class="card-body">

                    <div class="w-100">
                        <img src="{{ $employee->avatar ? $employee->avatar : asset('public/images/undraw_profile.svg') }}" class="img-employee rounded-circle mx-auto mb-3 text-center d-block bordered" width="160px" height="160px">
                    </div>

                    <ul class="list-group">
                        <li class="list-group-item d-flex justify-content-between align-items-center border-0 px-0 ">
                            {{ __('First Name') }}-{{ __('Last Name') }}
                            <span class="text-success">{{ $employee->full_name }}</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center border-0 px-0 ">
                            {{ __('Role') }}
                            <span class="text-success">{{ __($employee->role) }}</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center border-0 px-0 ">
                            {{ __('Phone number') }}
                            <span class="text-success">{{ $employee->phone_number }}</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center border-0 px-0 ">
                            {{ __('Affiliation') }}
                            <span class="text-success">{{ $employee->affiliation }}</span>
                        </li>
                        @if($employee->is_verified)
                        <li class="list-group-item d-flex justify-content-between align-items-center border-0 px-0 ">
                            {{ __('Verified at') }}
                            <span class="text-success">{{ $employee->is_verified }}</span>
                        </li>
                        @endif
                        <li class="list-group-item d-flex justify-content-between align-items-center border-0 px-0 ">
                            {{ __('Created at') }}
                            <span class="text-success">{{ $employee->created_at }}</span>
                        </li>
                    </ul>
                </div>
            </div>
        </div> <!-- col-md-4 -->
    </div> <!-- / row -->
</div>

@endsection
