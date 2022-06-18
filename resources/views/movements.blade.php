@extends('adminlte::page')

@section('title', 'Movements')

@section('content_header')
    <!-- Container's info -->
    <div class="container mt-3">
        <!-- Messages alert -->
        @if (session('flash'))
            <x-adminlte-alert theme="success" title="{{ session('flash') }}" dismissable></x-adminlte-alert>
        @endif
        @if ($errors->any())
            <x-adminlte-alert theme="danger" titlle="Error" dismissable>
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </x-adminlte-alert>
        @endif
        <div class="card border-white shadow">
            <div class="card-body">
                <div class="row justify-content-between">
                    <div class="col-12 col-lg-3">
                        <h3><strong>Movements</strong></h3>
                    </div>
                    <div class="col-12 col-lg-3">
                        <!-- customer registration button -->
                        <button type="button" class="btn btn-warning shadow-sm w-100" data-toggle="modal" data-target="#insertMovements">
                            <strong>Registration</strong>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop

@section('content')
    <div class="container">
        <!-- Movement's table -->
        <div class="card shadow border-white">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover" id="dtCustomers" class="display">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Date</th>
                                <th>Item</th>
                                <th>Quanty</th>
                                <th>Quanty boxes</th>
                                <th>Ubication</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Modal's insert -->
        <div class="modal fade" id="insertMovements" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="insertMovementsLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="insertMovementsLabel"><strong>Movement Registration</strong></h5>
                    </div>
                    <div class="modal-body">
                        <form action="{{ route('movementsRegister') }}" method="post" autocomplete="off" id="movementRegister">
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                            <input type="hidden" name="date_mo" id="date" value="@php date_default_timezone_set('America/Caracas'); echo $DateAndTime = date('Y-m-d H:i:s', time()); @endphp ">
                            <input type="hidden" name="user_id" value="1">
                            <div class="row">
                                <div class="col-12 col-lg-8">
                                    <div class="form-group">
                                        <label for="item">Item</label>
                                        <input type="text" name="item_mo" id="item" class="form-control shadow-sm" placeholder="Item">
                                    </div>
                                </div>
                                <div class="col-12 col-lg-4">
                                    <div class="form-group">
                                        <label for="quanty">Quanty</label>
                                        <input type="tel" name="quanty_mo" id="quanty" class="form-control shadow-sm" placeholder="Quanty">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-12 col-lg-4">
                                    <div class="form-group">
                                        <label for="qty_boxes">Quanty boxes</label>
                                        <input type="tel" name="qty_boxes_mo" id="qty_boxes" class="form-control shadow-sm" placeholder="Quanty boxes">
                                    </div>
                                </div>
                                <div class="col-12 col-lg-8">
                                    <div class="form-group">
                                        <label for="ubication">Ubication</label>
                                        <input type="text" name="ubication_mo" id="ubicaction" class="form-control shadow-sm" placeholder="Ubication">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-12 col-lg-6">
                                    <div class="form-group">
                                        <label for="customer">Customer</label>
                                        <select name="customer_id" id="customer" class="form-control shadow-sm">
                                            @foreach($customers as $customer)
                                                <option value="{{ $customer->id }}">{{ $customer->name_cu }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-12 col-lg-6">
                                    <div class="form-group">
                                        <label for="condition">Condition</label>
                                        <select name="condition_id" id="condition" class="form-control shadow-sm">
                                            @foreach($conditions as $condition)
                                                <option value="{{ $condition->id }}">{{ $condition->condition_co }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-12 col-lg-6">
                                    <div class="form-group">
                                        <label for="status">Status</label>
                                        <input type="text" name="status_id" id="status" value="1">
                                        <select name="status_id" id="status" class="form-control shadow-sm">
                                            @foreach($status as $statu)
                                                <option value="{{ $statu->id }}">{{ $statu->status_st }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="observation">Observation</label>
                                <textarea name="observation_mo" id="observation" cols="12" rows="2" class="form-control shadow-sm" placeholder="Observation"></textarea>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" form="movementRegister" class="btn btn-warning">Save</button>
                        <button type="button" class="btn btn-outline-secondary" data-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Modal's update -->
        <div class="modal fade" id="editCustomer" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="editCustomerLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="editCustomerLabel"><strong>Edit Customer</strong></h5>
                    </div>
                    <div class="modal-body">
                        <form id="updateCustomer">
                            <input type="hidden" name="id" id="idCustomerEdit">
                            <input type="hidden" name="_token" id="token" value="{{ csrf_token() }}">
                            <div class="row">
                                <div class="col-12 col-lg-7">
                                    <div class="form-group">
                                        <label for="name_cu">Name</label>
                                        <input type="text" id="nameEdit" name="name_cu" class="form-control shadow-sm">
                                    </div>
                                </div>
                                <div class="col-12 col-lg-5">
                                    <div class="form-group">
                                        <label for="phone_cu">Phone</label>
                                        <input type="tel" id="phoneEdit" name="phone_cu" class="form-control shadow-sm">
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" id="btnEdit" form="updateCustomer" class="btn btn-warning shadow-sm" onclick="updateCustomer();">Edit</button>
                        <button type="button" class="btn btn-outline-secondary" data-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal's delete -->
        <div class="modal fade" id="deleteCustomer" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="deleteCustomerLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="deleteCustomerLabel"><strong>Delete Customer</strong></h5>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" id="idCustomerDelete">
                        <p class="lead">Do you want to delete the customer?</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" id="btnDelete" class="btn btn-warning">Delete</button>
                        <button type="button" class="btn btn-outline-secondary" data-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop