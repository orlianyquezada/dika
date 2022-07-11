@extends('adminlte::page')

@section('title', 'Items')

@section('content_header')
    <!-- Container's info -->
    <div class="container mt-3">
        <!-- Messages alert -->
        @if (session('flash'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('flash') }}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
        @else
            <div id="alertSuccess"></div>
        @endif
        @if ($errors->any())
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
        @else
            <div id="alertDanger"></div>
        @endif
        <div class="card border-white shadow">
            <div class="card-body">
                <div class="row justify-content-between">
                    <div class="col-12 col-lg-2">
                        <h3><strong>Items</strong></h3>
                    </div>
                    <div class="col-12 col-lg-3">
                        <!-- items register button -->
                        <button type="button" class="btn btn-warning shadow-sm w-100" data-toggle="modal" data-target="#insertItem">
                            <strong>Register item</strong>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop

@section('content')
    <div class="container">
        <!-- Items's table -->
        <div class="card border-white shadow">
            <div class="card-body">
                <table class="table table-striped table-bordered dt-responsive nowrap dataTable_width_auto display" id="dtItems" style="width:100%">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Date</th>
                            <th>Vendor/Brand</th>
                            <th>Item</th>
                            <th>Customer</th>
                            <th>Quanty</th>
                            <th>Qty boxes</th>
                            <th>Ubication</th>
                            <th>Conditions</th>
                            <th>Status</th>
                            <th>Shipment</th>
                            <th>Adress</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Modal's insert -->
        <div class="modal fade" id="insertItem" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="insertItemLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-scrollable modal-xl">
                <div class="modal-content">
                    <div class="modal-header bg-warning">
                        <h5 class="modal-title" id="insertItemLabel"><strong>Register item</strong></h5>
                    </div>
                    <div class="modal-body">
                        <form id="registerItem" autocomplete="off">
                            <input type="hidden" name="_token" id="token" value="{{ csrf_token() }}">
                            <input type="hidden" name="datetime_input_it" id="datetimeInsert" value="@php date_default_timezone_set('America/Caracas'); echo $DateAndTime = date('Y-m-d H:i:s', time()); @endphp ">
                            <input type="hidden" name="user_id" value="{{ Auth::user()->id }}">
                            <div class="row">
                                <div class="col-12 col-lg-8">
                                    <div class="form-group">
                                        <label for="itemInsert">Item</label>
                                        <input type="text" name="item_it" id="itemInsert" class="form-control shadow-sm" placeholder="Item">
                                    </div>
                                </div>
                                <div class="col-12 col-lg-2">
                                    <div class="form-group">
                                        <label for="quantyInsert">Quanty</label>
                                        <input type="text" name="quanty_it" id="quantyInsert" class="form-control shadow-sm" placeholder="Quanty" onkeypress="return Numbers(event)" onkeyup="pierdeFoco(this)">
                                    </div>
                                </div>
                                <div class="col-12 col-lg-2">
                                    <div class="form-group">
                                        <label for="qtyBoxesInsert">Quanty boxes</label>
                                        <input type="text" name="qty_boxes_it" id="qtyBoxesInsert" class="form-control shadow-sm" placeholder="Quanty boxes" onkeypress="return Numbers(event)" onkeyup="pierdeFoco(this)">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-12 col-lg-6">
                                    <div class="form-group">
                                        <label for="ubicationInsert">Ubication</label>
                                        <input type="text" name="ubication_it" id="ubicationInsert" class="form-control shadow-sm" placeholder="Ubication">
                                    </div>
                                </div>
                                <div class="col-12 col-lg-3">
                                    <div class="form-group">
                                        <label for="conditionInsert">Conditions</label>
                                        <select name="condition_id" id="conditionInsert" class="form-control shadow-sm">
                                            <option value="">Select an option</option>
                                            @foreach ($conditions as $condition)
                                                <option value="{{ $condition->id }}">{{ $condition->condition_co }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-3">
                                    <div class="form-group">
                                        <label for="statusInsert">Status</label>
                                        <select name="status_id" id="statusInsert" class="form-control shadow-sm">
                                            <option value="">Select an option</option>
                                            @foreach ($status as $statu)
                                                <option value="{{ $statu->id }}">{{ $statu->status_st }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-12 col-lg-4">
                                    <div class="form-group">
                                        <label for="vendorBrandInsert">Vendor/Brand</label>
                                        <select name="customer_id" id="vendorBrandInsert" class="form-control shadow-sm">
                                            @foreach ($customers as $customer)
                                                <option value="{{ $customer->id }}">{{ $customer->name_cu }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-12 col-lg-4">
                                    <div class="form-group">
                                        <label for="customerInsert">Customer</label>
                                        <select name="sub_customer_id" id="customerInsert" class="form-control shadow-sm" disabled></select>
                                    </div>
                                </div>
                                <div class="col-12 col-lg-4">
                                    <div class="form-group">
                                        <label for="employeeInsert">Employee</label>
                                        <select name="employee_id" id="employeeInsert" class="form-control shadow-sm">
                                            <option value="">Select an option</option>
                                            @foreach ($users as $user)
                                                <option value="{{ $user->id }}">{{ $user->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-12 col-lg-3">
                                    <div class="form-group">
                                        <label for="datimeEdit">Date and time of exit</label>
                                        <div class="input-group date" id="datetimepicker4" data-target-input="nearest">
                                            <input type="text" class="form-control datetimepicker-input" data-target="#datetimepicker4" id="datetimeInsert" name="datetime_exit_it"/>
                                            <div class="input-group-append" data-target="#datetimepicker4" data-toggle="datetimepicker">
                                                <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12 col-lg-3">
                                    <div class="form-group">
                                        <label for="shipmentInsert">Shipment</label>
                                        <select name="shipment_id" id="shipmentInsert" class="form-control shadow-sm">
                                            <option value="">Select an option</option>
                                            @foreach ($shipments as $shipment)
                                                <option value="{{ $shipment->id }}">{{ $shipment->shipment_sh }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-12 col-lg-6">
                                    <label for="addressInsert">Address</label>
                                    <input type="text" name="address_it" id="addressInsert" class="form-control shadow-sm" placeholder="Address">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="observationInsert">Observation</label>
                                <textarea name="observation_input_it" id="observationInsert" cols="12" rows="2" class="form-control shadow-sm" placeholder="Observation"></textarea>
                            </div>
                        </form>
                        <div class="alertDangerModal"></div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" form="registerItem" class="btn btn-warning" onclick="registerItem(event);">Save</button>
                        <button type="button" class="btn btn-outline-secondary" data-dismiss="modal" onclick="cleanAlertsModal();">Close</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal's consult -->
        <div class="modal fade" id="consultItem" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="consultItemLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-scrollable modal-xl">
                <div class="modal-content">
                    <div class="modal-header bg-warning">
                        <h5 class="modal-title" id="consultItemLabel"><strong>Item information</strong></h5>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-12 col-lg-2">
                                <div class="form-group">
                                    <label for="dateInputConsult">Date of entry</label>
                                    <input type="text" name="datetime_it" id="dateInputConsult" class="form-control shadow-sm">
                                </div>
                            </div>
                            <div class="col-12 col-lg-6">
                                <div class="form-group">
                                    <label for="itemConsult">Item</label>
                                    <input type="text" name="item_it" id="itemConsult" class="form-control shadow-sm">
                                </div>
                            </div>
                            <div class="col-12 col-lg-2">
                                <div class="form-group">
                                    <label for="quantyConsult">Quanty</label>
                                    <input type="text" name="quanty_it" id="quantyConsult" class="form-control shadow-sm">
                                </div>
                            </div>
                            <div class="col-12 col-lg-2">
                                <div class="form-group">
                                    <label for="qtyBoxesConsult">Quanty boxes</label>
                                    <input type="text" name="qty_boxes_it" id="qtyBoxesConsult" class="form-control shadow-sm">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12 col-lg-6">
                                <div class="form-group">
                                    <label for="ubicationConsult">Ubication</label>
                                    <input type="text" name="ubication_it" id="ubicationConsult" class="form-control shadow-sm">
                                </div>
                            </div>
                            <div class="col-12 col-lg-3">
                                <div class="form-group">
                                    <label for="conditionInputConsult">Condition</label>
                                    <input type="text" name="condition_id" id="conditionInputConsult" class="form-control shadow-sm">
                                </div>
                            </div>
                            <div class="col-12 col-lg-3">
                                <div class="form-group">
                                    <label for="statusInputConsult">Status</label>
                                    <input type="text" name="status_id" id="statusInputConsult" class="form-control shadow-sm">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12 col-lg-4">
                                <div class="form-group">
                                    <label for="vendorBrandConsult">Vendor/Brand</label>
                                    <input type="text" name="customer_id" id="vendorBrandConsult" class="form-control shadow-sm">
                                </div>
                            </div>
                            <div class="col-12 col-lg-4">
                                <div class="form-group">
                                    <label for="customerConsult">Customer</label>
                                    <input type="text" name="customer_id" id="customerConsult" class="form-control shadow-sm">
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="observationInputConsult">Observation of entry</label>
                            <textarea name="observation_it" id="observationInputConsult" cols="12" rows="2" class="form-control shadow-sm" placeholder="Observation"></textarea>
                        </div>
                        <div class="row">
                            <div class="col-12 col-lg-2">
                                <div class="form-group">
                                    <label for="datetimeExitConsult">Date of Exit</label>
                                    <input type="text" name="datetime_it" id="datetimeExitConsult" class="form-control shadow-sm">
                                </div>
                            </div>
                            <div class="col-12 col-lg-7">
                                <div class="form-group">
                                    <label for="addressConsult">Address</label>
                                    <input type="text" name="ubication_it" id="addressConsult" class="form-control shadow-sm">
                                </div>
                            </div>
                            <div class="col-12 col-lg-3">
                                <div class="form-group">
                                    <label for="shipmentExitConsult">Shipment</label>
                                    <input type="text" name="shipment_id" id="shipmentExitConsult" class="form-control shadow-sm">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12 col-lg-4">
                                <div class="form-group">
                                    <label for="employeeExitConsult">Employee</label>
                                    <input type="text" name="employee_id" id="employeeExitConsult" class="form-control shadow-sm">
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="observationExitConsult">Observation of Exit</label>
                            <textarea name="observation_it" id="observationExitConsult" cols="12" rows="2" class="form-control shadow-sm" placeholder="Observation"></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-outline-secondary" data-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal's update open item -->
        <div class="modal fade" id="editItem" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="editItemLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-scrollable modal-xl">
                <div class="modal-content">
                    <div class="modal-header bg-warning">
                        <h5 class="modal-title" id="editItemLabel"><strong>Edit Item</strong></h5>
                    </div>
                    <div class="modal-body">
                        <form id="updateItem" autocomplete="off">
                            <input type="hidden" name="_token" id="token" value="{{ csrf_token() }}">
                            <input type="hidden" name="user_id" value="{{ Auth::user()->id }}">
                            <input type="hidden" name="id" id="idItemEdit">
                            <div class="row">
                                <div class="col-12 col-lg-3">
                                    <div class="form-group">
                                        <label for="datetimeInputEdit">Date and time of input</label>
                                        <div class="input-group date" id="datetimepicker2" data-target-input="nearest">
                                            <input type="text" class="form-control datetimepicker-input" data-target="#datetimepicker2" id="datetimeInputEdit" name="datetime_input_it"/>
                                            <div class="input-group-append" data-target="#datetimepicker2" data-toggle="datetimepicker">
                                                <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12 col-lg-5">
                                    <div class="form-group">
                                        <label for="itemEdit">Item</label>
                                        <input type="text" name="item_it" id="itemEdit" class="form-control shadow-sm" placeholder="Item">
                                    </div>
                                </div>
                                <div class="col-12 col-lg-2">
                                    <div class="form-group">
                                        <label for="quantyEdit">Quanty</label>
                                        <input type="text" name="quanty_it" id="quantyEdit" class="form-control shadow-sm" placeholder="Quanty" onkeypress="return Numbers(event)" onkeyup="pierdeFoco(this)">
                                    </div>
                                </div>
                                <div class="col-12 col-lg-2">
                                    <div class="form-group">
                                        <label for="qtyBoxesEdit">Quanty boxes</label>
                                        <input type="text" name="qty_boxes_it" id="qtyBoxesEdit" class="form-control shadow-sm" placeholder="Quanty boxes" onkeypress="return Numbers(event)" onkeyup="pierdeFoco(this)">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-12 col-lg-6">
                                    <div class="form-group">
                                        <label for="ubicationEdit">Ubication</label>
                                        <input type="text" name="ubication_it" id="ubicationEdit" class="form-control shadow-sm" placeholder="Ubication">
                                    </div>
                                </div>
                                <div class="col-12 col-lg-3">
                                    <div class="form-group">
                                        <label for="conditionEdit">Conditions</label>
                                        <select name="condition_id" id="conditionEdit" class="form-control shadow-sm">
                                            <option value="">Select an option</option>
                                            @foreach ($conditions as $condition)
                                                <option value="{{ $condition->id }}">{{ $condition->condition_co }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-12 col-lg-3">
                                    <div class="form-group">
                                        <label for="statusEdit">Status of Entry</label>
                                        <select name="status_id" id="statusEdit" class="form-control shadow-sm">
                                            <option value="">Select an option</option>
                                            @foreach ($status as $statu)
                                                <option value="{{ $statu->id }}">{{ $statu->status_st }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-12 col-lg-4">
                                    <div class="form-group">
                                        <label for="vendorBrandEdit">Vendor/Brand</label>
                                        <select name="customer_id" id="vendorBrandEdit" class="form-control shadow-sm">
                                            @foreach ($customers as $customer)
                                                <option value="{{ $customer->id }}">{{ $customer->name_cu }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-12 col-lg-4">
                                    <div class="form-group">
                                        <label for="customerEdit">Customer</label>
                                        <select name="sub_customer_id" id="customerEdit" class="form-control shadow-sm"></select>
                                    </div>
                                </div>
                                <div class="col-12 col-lg-4">
                                    <div class="form-group">
                                        <label for="employeeEdit">Employee</label>
                                        <select name="employee_id" id="employeeEdit" class="form-control shadow-sm">
                                            <option value="">Select an option</option>
                                            @foreach ($users as $user)
                                                <option value="{{ $user->id }}">{{ $user->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-12 col-lg-3">
                                    <div class="form-group">
                                        <label for="datetimeExitEdit">Date and time of exit</label>
                                        <div class="input-group date" id="datetimepicker3" data-target-input="nearest">
                                            <input type="text" class="form-control datetimepicker-input" data-target="#datetimepicker3" id="datetimeExitEdit" name="datetime_exit_it"/>
                                            <div class="input-group-append" data-target="#datetimepicker3" data-toggle="datetimepicker">
                                                <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12 col-lg-3">
                                    <div class="form-group">
                                        <label for="shipmentExitEdit">Shipment</label>
                                        <select name="shipment_id" id="shipmentExitEdit" class="form-control shadow-sm">
                                            <option value="">Select an option</option>
                                            @foreach ($shipments as $shipment)
                                                <option value="{{ $shipment->id }}">{{ $shipment->shipment_sh }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-12 col-lg-6">
                                    <label for="addressEdit">Address</label>
                                    <input type="text" name="address_it" id="addressEdit" class="form-control shadow-sm" placeholder="Address">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="observationInputEdit">Observation of Input</label>
                                <textarea name="observation_input_it" id="observationInputEdit" cols="12" rows="2" class="form-control shadow-sm" placeholder="Observation"></textarea>
                            </div>
                            <div class="form-group">
                                <label for="observationExitEdit">Observation of Exit</label>
                                <textarea name="observation_exit_it" id="observationExitEdit" cols="12" rows="2" class="form-control shadow-sm" placeholder="Observation"></textarea>
                            </div>
                        </form>
                        <div id="alertDangerUpdate"></div>
                        <div id="alertSuccessUpdate"></div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" form="updateItem" class="btn btn-warning" onclick="updateItem();">Update</button>
                        <button type="button" class="btn btn-outline-secondary" data-dismiss="modal" onclick="cleanAlertsModal();">Close</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal's delete -->
        <div class="modal fade" id="deleteItem" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="deleteItemLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header bg-warning">
                        <h5 class="modal-title" id="deleteItemLabel"><strong>Delete Item</strong></h5>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" id="idItemDelete">
                        <p class="lead">Do you want to delete the item?</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" id="btnDelete" class="btn btn-warning" onclick="confirmDelete();">Delete</button>
                        <button type="button" class="btn btn-outline-secondary" data-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal's close -->
        <div class="modal fade" id="closeItem" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="closeItemLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-scrollable modal-xl">
                <div class="modal-content">
                    <div class="modal-header bg-warning">
                        <h5 class="modal-title" id="closeItemLabel"><strong>Shut Item</strong></h5>
                    </div>
                    <div class="modal-body">
                        <form id="itemClose" autocomplete="off">
                            <input type="hidden" name="_token" id="token" value="{{ csrf_token() }}">
                            <input type="hidden" name="id" id="idItemClose">
                            <input type="hidden" name="user_id" value="{{ Auth::user()->id }}">
                            <input type="hidden" name="datetime_exit_it" id="datetimeClose" value="@php date_default_timezone_set('America/Caracas'); echo $DateAndTime = date('Y-m-d H:i:s', time()); @endphp ">
                            <div class="row">
                                <div class="col-12 col-lg-5">
                                    <div class="form-group">
                                        <label for="addressClose">Address</label>
                                        <input type="text" name="address_it" id="addressClose" class="form-control shadow-sm" placeholder="Address">
                                    </div>
                                </div>
                                <div class="col-12 col-lg-4">
                                    <div class="form-group">
                                        <label for="employeeClose">Employee</label>
                                        <select name="employee_id" id="employeeClose" class="form-control shadow-sm">
                                            <option value="">Select an opcion</option>
                                            @foreach ($users as $user)
                                                <option value="{{ $user->id }}">{{ $user->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-12 col-lg-3">
                                    <div class="form-group">
                                        <label for="statusClose">Status</label>
                                        <select name="status_id" id="statusClose" class="form-control shadow-sm">
                                            <option value="">Select an opcion</option>
                                            @foreach ($status as $statu)
                                                <option value="{{ $statu->id }}">{{ $statu->status_st }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-12 col-lg-4">
                                    <div class="form-group">
                                        <label for="vendorBrandClose">Vendor/Brand</label>
                                        <input type="text" name="customer_id" id="vendorBrandClose" class="form-control shadow-sm">
                                    </div>
                                </div>
                                <div class="col-12 col-lg-4">
                                    <div class="form-group">
                                        <label for="customerClose">Customer</label>
                                        <select name="sub_customer_id" id="customerClose" class="form-control shadow-sm customerDinamico">
                                        </select>
                                    </div>
                                </div>
                                <div class="col-12 col-lg-4">
                                    <div class="form-group">
                                        <label for="shipmentClose">Shipment</label>
                                        <select name="shipment_id" id="shipmentClose" class="form-control shadow-sm">
                                            <option value="">Select an opcion</option>
                                            @foreach ($shipments as $shipment)
                                                <option value="{{ $shipment->id }}">{{ $shipment->shipment_sh }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="observationClose">Observation</label>
                                <textarea name="observation_exit_it" id="observationClose" cols="12" rows="2" class="form-control shadow-sm" placeholder="Observation"></textarea>
                            </div>
                        </form>
                        <div id="alertDangerClose"></div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" id="btnClose" form="itemClose" class="btn btn-warning" onclick="closeItem(event);">Shut</button>
                        <button type="button" class="btn btn-outline-secondary" data-dismiss="modal" onclick="cleanAlertsModal();">Close</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop

@section('css')
    <link rel="stylesheet" href="/css/admin_custom.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/tempusdominus-bootstrap-4/5.39.0/css/tempusdominus-bootstrap-4.min.css" integrity="sha512-3JRrEUwaCkFUBLK1N8HehwQgu8e23jTH4np5NHOmQOobuC4ROQxFwFgBLTnhcnQRMs84muMh0PnnwXlPq5MGjg==" crossorigin="anonymous" />
    <style>
        table.dataTable.dataTable_width_auto {
            width: auto;
        }
    </style>
@stop

@section('js')
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.0/moment.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/tempusdominus-bootstrap-4/5.39.0/js/tempusdominus-bootstrap-4.min.js" integrity="sha512-k6/Bkb8Fxf/c1Tkyl39yJwcOZ1P4cRrJu77p83zJjN2Z55prbFHxPs9vN7q3l3+tSMGPDdoH51AEU8Vgo1cgAA==" crossorigin="anonymous"></script>
    <script>
        $(function () {
            $('#datetimepicker1').datetimepicker({
                defaultDate: $('#datetimeEdit').val(),
                maxDate: new Date(),
                format: 'YYYY-MM-DD HH:mm:ss'
            });
        });

        $(function () {
            $('#datetimepicker2').datetimepicker({
                defaultDate: $('#datetimeInputEdit').val(),
                maxDate: new Date(),
                format: 'YYYY-MM-DD HH:mm:ss'
            });
        });

        $(function () {
            $('#datetimepicker3').datetimepicker({
                defaultDate: $('#datetimeExit').val(),
                maxDate: new Date(),
                format: 'YYYY-MM-DD HH:mm:ss'
            });
        });

        $(function () {
            $('#datetimepicker4').datetimepicker({
                format: 'YYYY-MM-DD HH:mm:ss'
            });
        });

        $(document).ready( function () {
            $('#dtItems').DataTable({
                order: [[ 1, "desc" ]],
                responsive: true,
                autoWidth: false,
                buttons:[
                    {
                        extend: 'excelHtml5',
                        text: '<i class="fas fa-file-excel"></i>',
                        titleAttr: 'Export to excel',
                        className: 'btn btn-success'
                    }
                ],
                ajax:{
                    url: 'all-items',
                    method: "GET",
                },
                dom: '<"row"<"col-sm-12 col-md-1"<"dt-buttons btn-group flex-wrap"B>><"col-sm-12 col-md-11"f>>t<"row justify-content-between"<"col-sm-12 col-md-4 pt-2"l><"col-sm-12 col-md-3 pt-0"i><"col-sm-12 col-md-4"p>>',
                columns:[
                    {data: 'id'},
                    {data: 'datetime_input_it'},
                    {data: 'customer_id'},
                    {data: 'item_it'},
                    {data: 'sub_customer_id'},
                    {data: 'quanty_it'},
                    {data: 'qty_boxes_it'},
                    {data: 'ubication_it'},
                    {data: 'id'},
                    {data: 'id'},
                    {data: 'shipment_id'},
                    {data: 'address_it'},
                    {width: "20%", orderable: false, data: 'id',
                    render: function(data,t,w,meta){
                        return '<div class="btn-group btn-group-sm justify-content-end" role="group" aria-label=""><button onclick="consultItem('+data+');" class="btn btn-xs btn-ligth text-dark" title="Edit"><i class="fa fa-fw fa-eye"></i></button><button onclick="editItem('+data+');" class="btn btn-xs btn-ligth text-dark" title="Edit"><i class="fa fa-fw fa-pen"></i></button><button class="btn btn-xs btn-ligth text-dark" title="Delete" onclick="deleteItem('+data+')"><i class="fa fa-fw fa-trash"></i></button><button class="btn btn-xs btn-ligth text-dark" title="Close" onclick="openClose('+data+');"><i class="fa fa-fw fa-lock"></i></button></div>';
                    }}
                ]
            });
        } );

        function registerItem(event){
            event.preventDefault();
            $.ajax({
                headers: {'X-CSRF-TOKEN': $('input[name=_token]').val()},
                type: "POST",
                url: 'register-item',
                data: $('form#registerItem').serialize(),
                success: function(data){
                    $('#insertItem').modal('hide');
                    $('#itemInsert').val('');
                    $('#quantyInsert').val('');
                    $('#qtyBoxesInsert').val('');
                    $('#ubicationInsert').val('');
                    $('#customerInsert').val('');
                    $('#conditionInsert').val('');
                    $('#statusInsert').val('');
                    $('#employeeInsert').val('');
                    $('#shipmentInsert').val('');
                    $('#datetimeInsert').val('');
                    $('#addressInsert').val('');
                    $('#observationInsert').val('');
                    $('#dtItems').DataTable().ajax.reload();
                    $('#alertSuccess').empty();
                    $('#alertSuccess').html('<div class="alert alert-success alert-dismissible fade show" role="alert">¡The item has been successfully edited!<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
                },
                error: function(data){
                    $('.alertDangerModal').empty();
                    $('.alertDangerModal').html('<div class="alert alert-danger alert-dismissible fade show" role="alert"><ul id="listAlert"></ul><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
                    var resultado = data.responseJSON.errors;
                    var contenido = '';
                    $.each(resultado, function(index, value) {
                        contenido += '<li>'+value+'</li>';
                    });
                    $("#listAlert").html(contenido);
                }
            });
        }

        $('#vendorBrandInsert').click( function(){
            $.ajax({
                type: "GET",
                url: 'consult-sub-customer/'+$('#vendorBrandInsert').val(),
                success: function(data){
                    $("#customerInsert").prop('disabled',false);
                    var tamano = data.length;
                    var contenido = '';
                    contenido += '<option value="">Select an option</option>';
                    for (var i=0; i<tamano; i++) {
                        contenido += '<option value="'+data[i].id+'">'+data[i].name_cu+'</option>';
                    }
                    $("#customerInsert").html(contenido);
                },
                error: function(data){
                    $('#insertItem').modal('hide');
                    $('#alertDanger').empty();
                    $('#alertDanger').html('<div class="alert alert-danger alert-dismissible fade show" role="alert">¡Information not available!<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
                }
            });
        });

        function consultItem(idItem){
            $.ajax({
                type: "GET",
                url: 'consult-item/'+idItem,
                success: function(data){
                    $('#consultItem').modal('show');
                    $('#dateInputConsult').val(data[0].datetime_input_it).prop('disabled', true);
                    $('#itemConsult').val(data[0].item_it).prop('disabled', true);
                    $('#quantyConsult').val(data[0].quanty_it).prop('disabled', true);
                    $('#qtyBoxesConsult').val(data[0].qty_boxes_it).prop('disabled', true);
                    $('#ubicationConsult').val(data[0].ubication_it).prop('disabled', true);
                    $('#conditionInputConsult').val(data[3].condition_co).prop('disabled', true);
                    $('#statusInputConsult').val(data[4].status_st).prop('disabled', true);
                    $('#vendorBrandConsult').val(data[1].name_cu).prop('disabled', true);
                    $('#observationInputConsult').val(data[0].observation_input_it).prop('disabled', true);
                    if (data[0].datetime_exit_it == null && data[0].address_it == null && data[0].observation_exit_it == null && data[2] == null && data[5] == null && data[6] == null){
                        $('#datetimeExitConsult').val('Not assigned yet').prop('disabled', true);
                        $('#addressConsult').val('Not assigned yet').prop('disabled', true);
                        $('#observationExitConsult').val('Not assigned yet').prop('disabled', true);
                        $('#customerConsult').val('Not assigned yet').prop('disabled', true);
                        $('#shipmentExitConsult').val('Not assigned yet').prop('disabled', true);
                        $('#employeeExitConsult').val('Not assigned yet').prop('disabled', true);
                    }else{
                        $('#datetimeExitConsult').val(data[0].datetime_exit_it).prop('disabled', true);
                        $('#addressConsult').val(data[0].address_it).prop('disabled', true);
                        $('#observationExitConsult').val(data[0].observation_exit_it).prop('disabled', true);
                        $('#customerConsult').val(data[2].name_cu).prop('disabled', true);
                        $('#shipmentExitConsult').val(data[5].shipment_sh).prop('disabled', true);
                        $('#employeeExitConsult').val(data[6].name).prop('disabled', true);
                    }
                },
                error: function(data){
                    $('#alertDanger').empty();
                    $('#alertDanger').html('<div class="alert alert-danger alert-dismissible fade show" role="alert">¡Information not available!<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
                }
            });
        }

        function editItem(idItem){
            $.ajax({
                type: "GET",
                url: 'consult-item/'+idItem,
                success: function(data){
                    console.log(data[9]);
                    $('#editItem').modal('show');
                    $('#idItemEdit').val(data[0].id);
                    $('#datetimeInputEdit').val(data[0].datetime_input_it);
                    $('#itemEdit').val(data[0].item_it);
                    $('#quantyEdit').val(data[0].quanty_it);
                    $('#qtyBoxesEdit').val(data[0].qty_boxes_it);
                    $('#ubicationEdit').val(data[0].ubication_it);
                    $('#conditionEdit').val(data[3].id);
                    $('#statusEdit').val(data[4].id);
                    $('#vendorBrandEdit').val(data[0].customer_id);
                    $('#observationInputEdit').val(data[0].observation_input_it);
                    if (data[0].datetime_exit_it == null && data[0].address_it == null && data[0].observation_exit_it == null && data[2] == null && data[5] == null && data[6] == null){
                        $('#datetimeExitEdit').val('Not assigned yet').prop('disabled', true);
                        $('#addressEdit').val('Not assigned yet').prop('disabled', true);
                        $('#observationExitEdit').val('Not assigned yet').prop('disabled', true);
                        var contenido = '';
                        contenido += '<option value="">Not assigned yet</option>';
                        $("#customerEdit").html(contenido);
                        $("#shipmentExitEdit").html(contenido);
                        $("#employeeEdit").html(contenido);
                        $('#customerEdit').prop('disabled', true);
                        $('#shipmentExitEdit').prop('disabled', true);
                        $('#employeeEdit').prop('disabled', true);
                    }else{
                        $('#datetimeExitEdit').val(data[0].datetime_exit_it).prop('disabled',false);
                        $('#addressEdit').val(data[0].address_it).prop('disabled',false);
                        $('#observationExitEdit').val(data[0].observation_exit_it).prop('disabled',false);
                        var tamano1 = data[8].length;
                        var contenido1 = '';
                        for (var i=0; i<tamano1; i++) {
                            contenido1 += '<option value="'+data[8][i].id+'">'+data[8][i].name_cu+'</option>';
                        }
                        $("#customerEdit").html(contenido1);
                        $('#customerEdit').val(data[2].id).prop('disabled',false);
                        var tamano2 = data[9].length;
                        var contenido2 = '';
                        for (var i=0; i<tamano2; i++) {
                            contenido2 += '<option value="'+data[9][i].id+'">'+data[9][i].shipment_sh+'</option>';
                        }
                        $("#shipmentExitEdit").html(contenido2);
                        $('#shipmentExitEdit').val(data[5].id).prop('disabled',false);
                        var tamano3 = data[10].length;
                        var contenido3 = '';
                        for (var i=0; i<tamano3; i++) {
                            contenido3 += '<option value="'+data[10][i].id+'">'+data[10][i].name+'</option>';
                        }
                        $("#employeeEdit").html(contenido3);
                        $('#employeeEdit').val(data[6].id).prop('disabled',false);
                    }
                },
                error: function(data){
                    $('#alertDanger').empty();
                    $('#alertDanger').html('<div class="alert alert-danger alert-dismissible fade show" role="alert">¡Information not available!<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
                }
            });
        }

        $('#vendorBrandEdit').change( function(){
            $.ajax({
                type: "GET",
                url: 'consult-sub-customer/'+$('#vendorBrandEdit').val(),
                success: function(data){
                    var tamano = data.length;
                    var contenido = '';
                    contenido += '<option value="">Select an option</option>';
                    for (var i=0; i<tamano; i++) {
                        contenido += '<option value="'+data[i].id+'">'+data[i].name_cu+'</option>';
                    }
                    $("#customerEdit").html(contenido);
                },
                error: function(data){
                    $('#insertItem').modal('hide');
                    $('#alertDanger').empty();
                    $('#alertDanger').html('<div class="alert alert-danger alert-dismissible fade show" role="alert">¡Information not available!<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
                }
            });
        });

        function updateItem(){
            $.ajax({
                headers: {'X-CSRF-TOKEN': $('input[name=_token]').val()},
                type: "POST",
                url: 'update-item/'+$('#idItemEdit').val(),
                data: $('form#updateItem').serialize(),
                success: function(data){
                    $('#editItem').modal('hide');
                    $('#dtItems').DataTable().ajax.reload();
                    $('#alertSuccess').empty();
                    $('#alertSuccess').html('<div class="alert alert-success alert-dismissible fade show" role="alert">¡The item has been successfully edited!<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
                },
                error: function(data){
                    $('#alertDangerUpdate').empty();
                    $('#alertDangerUpdate').html('<div class="alert alert-danger alert-dismissible fade show" role="alert"><ul id="listAlert"></ul><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
                    var resultado = data.responseJSON.errors;
                    var contenido = '';
                    $.each(resultado, function(index, value) {
                        contenido += '<li>'+value+'</li>';
                    });
                    $("#listAlert").html(contenido);
                }
            });
        }

        function deleteItem(idItem){
            $('#idItemDelete').val(idItem);
            $('#deleteItem').modal('show');
        }

        function confirmDelete(){
            $.ajax({
                type: "GET",
                url: 'delete-item/'+$('#idItemDelete').val(),
                success: function(data){
                    $('#deleteItem').modal('hide');
                    $('#dtItems').DataTable().ajax.reload();
                    $('#alertSuccess').empty();
                    $('#alertSuccess').html('<div class="alert alert-success alert-dismissible fade show" role="alert">¡The item has been successfully deleted!<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
                },
                error: function(data){
                    $('#deleteItem').modal('hide');
                    $('#alertDanger').empty();
                    $('#alertDanger').html('<div class="alert alert-danger alert-dismissible fade show" role="alert">¡Information not available!<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
                }
            });
        }

        function openClose(idItem){
            $.ajax({
                type: "GET",
                url: 'consult-item/'+idItem,
                success: function(data){
                    console.log(data[1].name_cu);
                    $('#vendorBrandClose').val(data[1].name_cu).prop('disabled',true);
                    var customer = data[1].id;
                    subCustomersDinamicos(customer);
                },
                error: function(data){
                    $('#editItemOpen').modal('hide');
                    $('#alertDanger').empty();
                    $('#alertDanger').html('<div class="alert alert-danger alert-dismissible fade show" role="alert">¡Information not available!<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
                }
            });
            $('#idItemClose').val(idItem);
            $('#closeItem').modal('show');
        }

        function closeItem(idItem){
            $.ajax({
                headers: {'X-CSRF-TOKEN': $('input[name=_token]').val()},
                type: "POST",
                url: 'register-close/'+$('#idItemClose').val(),
                data: $('form#itemClose').serialize(),
                success: function(data){
                    $('#closeItem').modal('hide');
                    $('#dtItems').DataTable().ajax.reload();
                    $('#alertSuccess').empty();
                    $('#alertSuccess').html('<div class="alert alert-success alert-dismissible fade show" role="alert">¡The item has been successfully closed!<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
                },
                error: function(data){
                    console.log(data);
                    $('#alertDangerClose').empty();
                    $('#alertDangerClose').html('<div class="alert alert-danger alert-dismissible fade show" role="alert"><ul id="listAlert"></ul><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
                    var resultado = data.responseJSON.errors;
                    var contenido = '';
                    $.each(resultado, function(index, value) {
                        contenido += '<li>'+value+'</li>';
                    });
                    $("#listAlert").html(contenido);
                }
            });
        }

        function subCustomersDinamicos(customer){
            $.ajax({
                type: "GET",
                url: 'consult-sub-customer/'+customer,
                success: function(data){
                    var tamano = data.length;
                    var contenido = '';
                    contenido += '<option value="">Select an opcion</option>';
                    for (var i=0; i<tamano; i++) {
                        contenido += '<option value="'+data[i].id+'">'+data[i].name_cu+'</option>';
                    }
                    $("#customerClose").html(contenido);
                },
                error: function(data){
                    $('#insertItem').modal('hide');
                    $('#alertDanger').empty();
                    $('#alertDanger').html('<div class="alert alert-danger alert-dismissible fade show" role="alert">¡Information not available!<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
                }
            });
        }

        function cleanAlertsModal(){
            $('#itemInsert').val('');
            $('#quantyInsert').val('');
            $('#qtyBoxesInsert').val('');
            $('#ubicationInsert').val('');
            $('#conditionInsert').val('');
            $('#statusInsert').val('');
            $('#observationInsert').val('');
            $('#datetimeInsert').val('');
            $('#addressInsert').val('');
            $('#observationInsert').val('');
            $('#customerInsert').val('').prop('disabled',true);
            $('#shipmentInsert').val('');
            $('#employeeInsert').val('');
            $('#dateInputConsult').val('');
            $('#itemConsult').val('');
            $('#quantyConsult').val('');
            $('#qtyBoxesConsult').val('');
            $('#ubicationConsult').val('');
            $('#conditionInputConsult').val('');
            $('#statusInputConsult').val('');
            $('#vendorBrandConsult').val('');
            $('#observationInputConsult').val('');
            $('#datetimeExitConsult').val('');
            $('#addressConsult').val('');
            $('#observationExitConsult').val('');
            $('#customerConsult').val('');
            $('#shipmentExitConsult').val('');
            $('#employeeExitConsult').val('');
            $('#addressClose').val('');
            $('#conditionClose').val('');
            $('#employeeClose').val('');
            $('#statusClose').val('');
            $('#shipementClose').val('');
            $('#observationClose').val('');
            $('#alertDangerClose').empty();
            $('.alertDangerModal').empty();
            $('#alertDangerUpdate').empty();
            $('#alertDangerUpdate').empty();
            $('#alertSuccessInput').empty();
            $('#alertDangerInput').empty();
            $('#alertSuccessExit').empty();
            $('#alertDangerExit').empty();
        }

        //Validaciones
        function Numbers(e) {
            key = e.keyCode || e.which;
            tecla = String.fromCharCode(key).toLowerCase();
            letras = "0123456789";
            especiales = "8-37-39-46";

            tecla_especial = false;
            for (var i in especiales) {
                if (key == especiales[i]) {
                tecla_especial = true;
                break;
                }
            }

            if (letras.indexOf(tecla) == -1 && !tecla_especial) {
                return false;
            }
        }

        function pierdeFoco(e){
            var valor = e.value.replace(/^0*/, '');
            e.value = valor;
        }
    </script>
@stop
