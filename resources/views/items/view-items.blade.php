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
            <div class="modal-dialog modal-dialog-scrollable modal-lg">
                <div class="modal-content">
                    <div class="modal-header bg-warning">
                        <h5 class="modal-title" id="insertItemLabel"><strong>Register item</strong></h5>
                    </div>
                    <div class="modal-body">
                        <form action="{{ route('item-register') }}" method="post" id="registerItem" autocomplete="off">
                            @csrf
                            <input type="hidden" name="datetime_it" id="datetimeInsert" value="@php date_default_timezone_set('America/Caracas'); echo $DateAndTime = date('Y-m-d H:i:s', time()); @endphp ">
                            <input type="hidden" name="user_id" value="{{ Auth::user()->id }}">
                            <div class="row">
                                <div class="col-12 col-lg-7">
                                    <div class="form-group">
                                        <label for="itemInsert">Item</label>
                                        <input type="text" name="item_it" id="itemInsert" class="form-control shadow-sm" placeholder="Item">
                                    </div>
                                </div>
                                <div class="col-12 col-lg-2">
                                    <div class="form-group">
                                        <label for="quantyInsert">Quanty</label>
                                        <input type="number" name="quanty_it" id="quantyInsert" class="form-control shadow-sm" placeholder="Quanty">
                                    </div>
                                </div>
                                <div class="col-12 col-lg-3">
                                    <div class="form-group">
                                        <label for="qty_boxesInsert">Quanty boxes</label>
                                        <input type="number" name="qty_boxes_it" id="qty_boxesInsert" class="form-control shadow-sm" placeholder="Quanty boxes">
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
                                        <label for="customer_id">Vendor/Brand</label>
                                        <select name="customer_id" id="customer_id" class="form-control shadow-sm">
                                            <option value="">Select an option</option>
                                            @foreach ($customers as $customer)
                                                <option value="{{ $customer->id }}">{{ $customer->name_cu }}</option>
                                            @endforeach
                                        </select>
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
                            </div>
                            <div class="row">
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
                            <div class="form-group">
                                <label for="observationInsert">Observation</label>
                                <textarea name="observation_it" id="observationInsert" cols="12" rows="2" class="form-control shadow-sm" placeholder="Observation"></textarea>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" form="registerItem" class="btn btn-warning">Save</button>
                        <button type="button" class="btn btn-outline-secondary" data-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal's consult -->
        <div class="modal fade" id="consultItem" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="consultItemLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-scrollable modal-lg">
                <div class="modal-content">
                    <div class="modal-header bg-warning">
                        <h5 class="modal-title" id="consultItemLabel"><strong>Item information</strong></h5>
                    </div>
                    <div class="modal-body">
                        <div id="titleInput" hidden><p class="lead">Item input information</p></div>
                        <div class="row">
                            <div class="col-12 col-lg-3">
                                <div class="form-group">
                                    <label for="dateInputConsult">Date</label>
                                    <input type="text" name="datetime_it" id="dateInputConsult" class="form-control shadow-sm">
                                </div>
                            </div>
                            <div class="col-12 col-lg-7">
                                <div class="form-group">
                                    <label for="itemConsult">Item</label>
                                    <input type="text" name="item_it" id="itemConsult" class="form-control shadow-sm">
                                </div>
                            </div>
                            <div class="col-12 col-lg-2">
                                <div class="form-group">
                                    <label for="quantyConsult">Quanty</label>
                                    <input type="number" name="quanty_it" id="quantyConsult" class="form-control shadow-sm">
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
                            <div class="col-12 col-lg-2">
                                <div class="form-group">
                                    <label for="qtyBoxesConsult">Quanty boxes</label>
                                    <input type="number" name="qty_boxes_it" id="qtyBoxesConsult" class="form-control shadow-sm">
                                </div>
                            </div>
                            <div class="col-12 col-lg-4">
                                <div class="form-group">
                                    <label for="customerPrimConsult">Vendor/Brand</label>
                                    <input type="text" name="customer_id" id="customerPrimConsult" class="form-control shadow-sm">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12 col-lg-2">
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
                        <div class="form-group">
                            <label for="observationInputConsult">Observation</label>
                            <textarea name="observation_it" id="observationInputConsult" cols="12" rows="2" class="form-control shadow-sm" placeholder="Observation"></textarea>
                        </div>
                        <div id="infoExit" hidden>
                            <hr class="display-4">
                            <p class="lead">Exit input information</p>
                            <div class="row">
                                <div class="col-12 col-lg-3">
                                    <div class="form-group">
                                        <label for="datetimeExitConsult">Date</label>
                                        <input type="text" name="datetime_it" id="datetimeExitConsult" class="form-control shadow-sm">
                                    </div>
                                </div>
                                <div class="col-12 col-lg-5">
                                    <div class="form-group">
                                        <label for="addressConsult">Address</label>
                                        <input type="text" name="ubication_it" id="addressConsult" class="form-control shadow-sm">
                                    </div>
                                </div>
                                <div class="col-12 col-lg-4">
                                    <div class="form-group">
                                        <label for="customerSecoConsult">Customer</label>
                                        <input type="text" name="customer_id" id="customerSecoConsult" class="form-control shadow-sm">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-12 col-lg-2">
                                    <div class="form-group">
                                        <label for="conditionExitConsult">Condition</label>
                                        <input type="text" name="condition_id" id="conditionExitConsult" class="form-control shadow-sm">
                                    </div>
                                </div>
                                <div class="col-12 col-lg-3">
                                    <div class="form-group">
                                        <label for="statusExitConsult">Status</label>
                                        <input type="text" name="status_id" id="statusExitConsult" class="form-control shadow-sm">
                                    </div>
                                </div>
                                <div class="col-12 col-lg-3">
                                    <div class="form-group">
                                        <label for="shipmentExitConsult">Shipment</label>
                                        <input type="text" name="shipment_id" id="shipmentExitConsult" class="form-control shadow-sm">
                                    </div>
                                </div>
                                <div class="col-12 col-lg-4">
                                    <div class="form-group">
                                        <label for="employeeExitConsult">Employee</label>
                                        <input type="text" name="employee_id" id="employeeExitConsult" class="form-control shadow-sm">
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="observationExitConsult">Observation</label>
                                <textarea name="observation_it" id="observationExitConsult" cols="12" rows="2" class="form-control shadow-sm" placeholder="Observation"></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-outline-secondary" data-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal's update open item -->
        <div class="modal fade" id="editItemOpen" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="editItemOpenLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-scrollable modal-lg">
                <div class="modal-content">
                    <div class="modal-header bg-warning">
                        <h5 class="modal-title" id="editItemOpenLabel"><strong>Edit Item</strong></h5>
                    </div>
                    <div class="modal-body">
                        <form id="updateItemOpen" autocomplete="off">
                            <input type="hidden" name="_token" id="token" value="{{ csrf_token() }}">
                            <input type="hidden" name="user_id" value="{{ Auth::user()->id }}">
                            <input type="hidden" name="id" id="idItemEdit">
                            <div class="row">
                                <div class="col-12 col-lg-3">
                                    <div class="form-group">
                                        <label for="datetimeEdit">Date and time</label>
                                        <input type="datetime" name="datetime_it" id="datetimeEdit" class="form-control shadow-sm">
                                    </div>
                                </div>
                                <div class="col-12 col-lg-7">
                                    <div class="form-group">
                                        <label for="itemEdit">Item</label>
                                        <input type="text" name="item_it" id="itemEdit" class="form-control shadow-sm" placeholder="Item">
                                    </div>
                                </div>
                                <div class="col-12 col-lg-2">
                                    <div class="form-group">
                                        <label for="quantyEdit">Quanty</label>
                                        <input type="number" name="quanty_it" id="quantyEdit" class="form-control shadow-sm" placeholder="Quanty">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-12 col-lg-3">
                                    <div class="form-group">
                                        <label for="qtyBoxesEdit">Quanty boxes</label>
                                        <input type="number" name="qty_boxes_it" id="qtyBoxesEdit" class="form-control shadow-sm" placeholder="Quanty boxes">
                                    </div>
                                </div>
                                <div class="col-12 col-lg-6">
                                    <div class="form-group">
                                        <label for="ubicationEdit">Ubication</label>
                                        <input type="text" name="ubication_it" id="ubicationEdit" class="form-control shadow-sm" placeholder="Ubication">
                                    </div>
                                </div>
                                <div class="col-12 col-lg-3">
                                    <div class="form-group">
                                        <label for="customerPrimEdit">Customers</label>
                                        <select name="customer_id" id="customerPrimEdit" class="form-control shadow-sm">
                                            @foreach ($customers as $customer)
                                                <option value="{{ $customer->id }}">{{ $customer->name_cu }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-12 col-lg-3">
                                    <div class="form-group">
                                        <label for="conditionEdit">Conditions</label>
                                        <select name="condition_id" id="conditionEdit" class="form-control shadow-sm">
                                            @foreach ($conditions as $condition)
                                                <option value="{{ $condition->id }}">{{ $condition->condition_co }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-12 col-lg-3">
                                    <div class="form-group">
                                        <label for="statusEdit">Status</label>
                                        <select name="status_id" id="statusEdit" class="form-control shadow-sm">
                                            @foreach ($status as $statu)
                                                <option value="{{ $statu->id }}">{{ $statu->status_st }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="observationEdit">Observation</label>
                                <textarea name="observation_it" id="observationEdit" cols="12" rows="2" class="form-control shadow-sm" placeholder="Observation"></textarea>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" form="updateItemOpen" class="btn btn-warning" onclick="updateItemOpen();">Update</button>
                        <button type="button" class="btn btn-outline-secondary" data-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal's update close item -->
        <div class="modal fade" id="editItemClose" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="editItemCloseLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-scrollable modal-lg">
                <div class="modal-content">
                    <div class="modal-header bg-warning">
                        <h5 class="modal-title" id="editItemCloseLabel"><strong>Edit Item</strong></h5>
                    </div>
                    <div class="modal-body">
                        <div class="accordion" id="accordionExample">
                            <div class="card border border-warning">
                                <div class="card-header bg-light" id="headingOne">
                                    <h2 class="mb-0">
                                    <button class="btn btn-link btn-block text-left text-dark text-decoration-none" type="button" data-toggle="collapse" data-target="#CollapseItemInpuInformation" aria-expanded="true" aria-controls="CollapseItemInpuInformation">
                                        Item input information
                                    </button>
                                    </h2>
                                </div>

                              <div id="CollapseItemInpuInformation" class="collapse" aria-labelledby="headingOne" data-parent="#accordionExample">
                                <div class="card-body">
                                    <form id="updateInputInfo" autocomplete="off">
                                        <input type="hidden" name="_token" id="token" value="{{ csrf_token() }}">
                                        <input type="hidden" name="user_id" value="{{ Auth::user()->id }}">
                                        <input type="hidden" name="id" id="idItemInputInfo">
                                        <div class="row">
                                            <div class="col-12 col-lg-3">
                                                <div class="form-group">
                                                    <label for="datetimeInput">Date and time</label>
                                                    <input type="datetime" name="datetime_it" id="datetimeInput" class="form-control shadow-sm">
                                                </div>
                                            </div>
                                            <div class="col-12 col-lg-7">
                                                <div class="form-group">
                                                    <label for="itemInput">Item</label>
                                                    <input type="text" name="item_it" id="itemInput" class="form-control shadow-sm" placeholder="Item">
                                                </div>
                                            </div>
                                            <div class="col-12 col-lg-2">
                                                <div class="form-group">
                                                    <label for="quantyInput">Quanty</label>
                                                    <input type="number" name="quanty_it" id="quantyInput" class="form-control shadow-sm" placeholder="Quanty">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-12 col-lg-2">
                                                <div class="form-group">
                                                    <label for="qtyBoxesInput">Quanty boxes</label>
                                                    <input type="number" name="qty_boxes_it" id="qtyBoxesInput" class="form-control shadow-sm" placeholder="Quanty boxes">
                                                </div>
                                            </div>
                                            <div class="col-12 col-lg-7">
                                                <div class="form-group">
                                                    <label for="ubicationInput">Ubication</label>
                                                    <input type="text" name="ubication_it" id="ubicationInput" class="form-control shadow-sm" placeholder="Ubication">
                                                </div>
                                            </div>
                                            <div class="col-12 col-lg-3">
                                                <div class="form-group">
                                                    <label for="customerPrimInput">Customers</label>
                                                    <select name="customer_id" id="customerPrimInput" class="form-control shadow-sm">
                                                        @foreach ($customers as $customer)
                                                            <option value="{{ $customer->id }}">{{ $customer->name_cu }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-12 col-lg-3">
                                                <div class="form-group">
                                                    <label for="conditionInput">Conditions</label>
                                                    <select name="condition_id" id="conditionInput" class="form-control shadow-sm">
                                                        @foreach ($conditions as $condition)
                                                            <option value="{{ $condition->id }}">{{ $condition->condition_co }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-12 col-lg-3">
                                                <div class="form-group">
                                                    <label for="statusInput">Status</label>
                                                    <select name="status_id" id="statusInput" class="form-control shadow-sm">
                                                        @foreach ($status as $statu)
                                                            <option value="{{ $statu->id }}">{{ $statu->status_st }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="observationInput">Observation</label>
                                            <textarea name="observation_it" id="observationInput" cols="12" rows="2" class="form-control shadow-sm" placeholder="Observation"></textarea>
                                        </div>
                                    </form>
                                </div>
                                <div class="card-footer">
                                    <button type="button" form="updateInputInfo" class="btn btn-warning" onclick="updateInputInfo();">Update</button>
                                </div>
                              </div>
                            </div>
                            <div class="card border border-warning">
                                <div class="card-header bg-light" id="headingTwo">
                                    <h2 class="mb-0">
                                        <button class="btn btn-link btn-block text-left collapsed text-dark text-decoration-none" type="button" data-toggle="collapse" data-target="#collapseExitInput" aria-expanded="false" aria-controls="collapseTwo">
                                            Information exit input
                                        </button>
                                    </h2>
                                </div>
                                <div id="collapseExitInput" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionExample">
                                    <div class="card-body">
                                        <form id="updateExitInfo" autocomplete="off">
                                            <input type="hidden" name="_token" id="token" value="{{ csrf_token() }}">
                                            <input type="hidden" name="user_id" value="{{ Auth::user()->id }}">
                                            <input type="hidden" name="item_id" id="itemIdExitInfo">
                                            <div class="row">
                                                <div class="col-12 col-lg-3"><div class="form-group">
                                                    <label for="datetimeExit">Date and time</label>
                                                    <input type="datetime" name="datetime_it" id="datetimeExit" class="form-control shadow-sm">
                                                </div></div>
                                                <div class="col-12 col-lg-5">
                                                    <div class="form-group">
                                                        <label for="addressExit">Address</label>
                                                        <input type="text" name="ubication_it" id="addressExit" class="form-control shadow-sm">
                                                    </div>
                                                </div>
                                                <div class="col-12 col-lg-4">
                                                    <div class="form-group">
                                                        <label for="subCustomerExit">Customer</label>
                                                        <select name="sub_customer_id" id="subCustomerExit" class="form-control shadow-sm">
                                                            @foreach ($customers as $customer)
                                                                <option value="{{ $customer->id }}">{{ $customer->name_cu }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-12 col-lg-2">
                                                    <div class="form-group">
                                                        <label for="conditionExit">Conditions</label>
                                                        <select name="condition_id" id="conditionExit" class="form-control shadow-sm">
                                                            @foreach ($conditions as $condition)
                                                                <option value="{{ $condition->id }}">{{ $condition->condition_co }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-12 col-lg-3">
                                                    <div class="form-group">
                                                        <label for="statusExit">Status</label>
                                                        <select name="status_id" id="statusExit" class="form-control shadow-sm">
                                                            @foreach ($status as $statu)
                                                                <option value="{{ $statu->id }}">{{ $statu->status_st }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-12 col-lg-3">
                                                    <div class="form-group">
                                                        <label for="shipmentExit">Shipment</label>
                                                        <select name="shipment_id" id="shipmentExit" class="form-control shadow-sm">
                                                            @foreach ($shipments as $shipment)
                                                                <option value="{{ $shipment->id }}">{{ $shipment->shipment_sh }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-12 col-lg-4">
                                                    <div class="form-group">
                                                        <label for="employeeExit">Employee</label>
                                                        <select name="employee_id" id="employeeExit" class="form-control shadow-sm">
                                                            @foreach ($users as $user)
                                                                <option value="{{ $user->id }}">{{ $user->name }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="observationExit">Observation</label>
                                                <textarea name="observation_it" id="observationExit" cols="12" rows="2" class="form-control shadow-sm"></textarea>
                                            </div>
                                        </form>
                                    </div>
                                    <div class="card-footer">
                                        <button type="button" form="updateExitInfo" class="btn btn-warning" onclick="updateExitInfo();">Update</button>
                                    </div>
                                </div>
                            </div>
                          </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-outline-secondary" data-dismiss="modal">Close</button>
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
            <div class="modal-dialog modal-dialog-scrollable modal-lg">
                <div class="modal-content">
                    <div class="modal-header bg-warning">
                        <h5 class="modal-title" id="closeItemLabel"><strong>Close Item</strong></h5>
                    </div>
                    <div class="modal-body">
                        <form id="itemClose" autocomplete="off">
                            <input type="hidden" name="_token" id="token" value="{{ csrf_token() }}">
                            <input type="hidden" name="item_id" id="idItemClose">
                            <input type="hidden" name="user_id" value="{{ Auth::user()->id }}">
                            <input type="hidden" name="datetime_it" id="datetimeClose" value="@php date_default_timezone_set('America/Caracas'); echo $DateAndTime = date('Y-m-d H:i:s', time()); @endphp ">
                            <div class="row">
                                <div class="col-12 col-lg-5">
                                    <div class="form-group">
                                        <label for="addressClose">Address</label>
                                        <input type="text" name="ubication_it" id="addressClose" class="form-control shadow-sm" placeholder="Address">
                                    </div>
                                </div>
                                <div class="col-12 col-lg-4">
                                    <div class="form-group">
                                        <label for="customerClose">Customer</label>
                                        <select name="sub_customer_id" id="customerClose" class="form-control shadow-sm">
                                            <option value="">Select an opcion</option>
                                            @foreach ($customers as $customer)
                                                <option value="{{ $customer->id }}">{{ $customer->name_cu }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-12 col-lg-3">
                                    <div class="form-group">
                                        <label for="conditionClose">Conditions</label>
                                        <select name="condition_id" id="conditionClose" class="form-control shadow-sm">
                                            <option value="">Select an opcion</option>
                                            @foreach ($conditions as $condition)
                                                <option value="{{ $condition->id }}">{{ $condition->condition_co }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
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
                                <div class="col-12 col-lg-3">
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
                            </div>
                            <div class="form-group">
                                <label for="observationClose">Observation</label>
                                <textarea name="observation_it" id="observationClose" cols="12" rows="2" class="form-control shadow-sm" placeholder="Observation"></textarea>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" id="btnClose" form="itemClose" class="btn btn-warning" onclick="closeItem();">Close</button>
                        <button type="button" class="btn btn-outline-secondary" data-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop

@section('css')
    <link rel="stylesheet" href="/css/admin_custom.css">
    <style>
        table.dataTable.dataTable_width_auto {
            width: auto;
        }
    </style>
@stop

@section('js')
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jszip/2.5.0/jszip.min.js"></script>
    <script>
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
                    {data: 'datetime_it'},
                    {data: 'name_cu'},
                    {data: 'item_it'},
                    {data: 'name_cu'},
                    {data: 'quanty_it'},
                    {data: 'qty_boxes_it'},
                    {data: 'ubication_it'},
                    {data: 'condition_co'},
                    {data: 'status_st'},
                    {data: 'shipment_sh'},
                    {data: 'ubication_it'},
                    {width: "20%", orderable: false, data: 'id',
                    render: function(data,t,w,meta){
                        return '<div class="btn-group btn-group-sm justify-content-end" role="group" aria-label=""><button onclick="consultItem('+data+');" class="btn btn-xs btn-ligth text-dark" title="Edit"><i class="fa fa-fw fa-eye"></i></button><button onclick="editItem('+data+');" class="btn btn-xs btn-ligth text-dark" title="Edit"><i class="fa fa-fw fa-pen"></i></button><button class="btn btn-xs btn-ligth text-dark" title="Delete" onclick="deleteItem('+data+')"><i class="fa fa-fw fa-trash"></i></button><button class="btn btn-xs btn-ligth text-dark" title="Close" onclick="openClose('+data+');"><i class="fa fa-fw fa-lock"></i></button></div>';
                    }}
                ]
            });
        } );

        function consultItem(idItem){
            $.ajax({
                type: "GET",
                url: 'consult-item/'+idItem,
                success: function(data){
                    var status = data[0];
                    if (status === 'open'){
                        $('#titleInput').prop('hidden',true);
                        $('#dateInputConsult').val(data[1][0].datetime_it).prop('disabled', true);
                        $('#itemConsult').val(data[1][0].item_it).prop('disabled', true);
                        $('#quantyConsult').val(data[1][0].quanty_it).prop('disabled', true);
                        $('#qtyBoxesConsult').val(data[1][0].qty_boxes_it).prop('disabled', true);
                        $('#ubicationConsult').val(data[1][0].ubication_it).prop('disabled', true);
                        $('#observationInputConsult').val(data[1][0].observation_it).prop('disabled', true);
                        $('#customerPrimConsult').val(data[1][0].name_cu).prop('disabled', true);
                        $('#conditionInputConsult').val(data[1][0].condition_co).prop('disabled', true);
                        $('#statusInputConsult').val(data[1][0].status_st).prop('disabled', true);
                        $('#infoExit').prop('hidden',true);
                    }else if (status == 'close'){
                        $('#titleInput').prop('hidden',false);
                        $('#dateInputConsult').val(data[1][0].datetime_it).prop('disabled', true);
                        $('#itemConsult').val(data[1][0].item_it).prop('disabled', true);
                        $('#quantyConsult').val(data[1][0].quanty_it).prop('disabled', true);
                        $('#qtyBoxesConsult').val(data[1][0].qty_boxes_it).prop('disabled', true);
                        $('#ubicationConsult').val(data[1][0].ubication_it).prop('disabled', true);
                        $('#observationInputConsult').val(data[1][0].observation_it).prop('disabled', true);
                        $('#customerPrimConsult').val(data[1][0].name_cu).prop('disabled', true);
                        $('#conditionInputConsult').val(data[1][0].condition_co).prop('disabled', true);
                        $('#statusInputConsult').val(data[1][0].status_st).prop('disabled', true);
                        $('#infoExit').prop('hidden',false);
                        $('#datetimeExitConsult').val(data[2][0].datetime_it).prop('disabled', true);
                        $('#addressConsult').val(data[2][0].ubication_it).prop('disabled', true);
                        $('#observationConsult').val(data[2][0].observation_it).prop('disabled', true);
                        $('#customerSecoConsult').val(data[2][0].name_cu).prop('disabled', true);
                        $('#conditionExitConsult').val(data[2][0].condition_co).prop('disabled', true);
                        $('#statusExitConsult').val(data[2][0].status_st).prop('disabled', true);
                        $('#shipmentExitConsult').val(data[2][0].shipment_sh).prop('disabled', true);
                        $('#employeeExitConsult').val(data[2][0].name).prop('disabled', true);
                        $('#observationExitConsult').val(data[2][0].observation_it).prop('disabled', true);
                    }
                },
                error: function(data){
                    $('#consultItem').modal('hide');
                    $('#alertDanger').html('<div class="alert alert-danger alert-dismissible fade show" role="alert">¡Information not available!<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
                }
            });
            $('#consultItem').modal('show');
        }

        function editItem(idItem){
            $.ajax({
                type: "GET",
                url: 'consult-item/'+idItem,
                success: function(data){
                    var status = data[0];
                    if (status == 'close'){
                        itemClose(idItem);
                    }else if (status == 'open'){
                        itemOpen(idItem);
                    }
                },
                error: function(data){
                    $('#alertDanger').html('<div class="alert alert-danger alert-dismissible fade show" role="alert">¡Information not available!<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
                }
            });
        }

        function itemOpen(idItem){
            $.ajax({
                type: "GET",
                url: 'consult-item/'+idItem,
                success: function(data){
                    $('#datetimeEdit').val(data[1][0].datetime_it);
                    $('#itemEdit').val(data[1][0].item_it);
                    $('#quantyEdit').val(data[1][0].quanty_it);
                    $('#qtyBoxesEdit').val(data[1][0].qty_boxes_it);
                    $('#ubicationEdit').val(data[1][0].ubication_it);
                    $('#observationEdit').val(data[1][0].observation_it);
                    $('#customerPrimEdit').val(data[1][0].customer_id);
                    $('#conditionInputEdit').val(data[1][0].condition_id);
                    $('#statusInputEdit').val(data[1][0].status_id);
                },
                error: function(data){
                    $('#editItemOpen').modal('hide');
                    $('#alertDanger').html('<div class="alert alert-danger alert-dismissible fade show" role="alert">¡Information not available!<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
                }
            });
            $('#editItemOpen').modal('show');
            $('#idItemEdit').val(idItem);
        }

        function itemClose(idItem){
            $.ajax({
                type: "GET",
                url: 'consult-item/'+idItem,
                success: function(data){
                    $('#datetimeInput').val(data[1][0].datetime_it);
                    $('#itemInput').val(data[1][0].item_it);
                    $('#quantyInput').val(data[1][0].quanty_it);
                    $('#qtyBoxesInput').val(data[1][0].qty_boxes_it);
                    $('#ubicationInput').val(data[1][0].ubication_it);
                    $('#observationInput').val(data[1][0].observation_it);
                    $('#customerPrimInput').val(data[1][0].customer_id);
                    $('#conditionInputInput').val(data[1][0].condition_id);
                    $('#statusInputInput').val(data[1][0].status_id);
                    $('#datetimeExit').val(data[2][0].datetime_it);
                    $('#addressExit').val(data[2][0].ubication_it);
                    $('#observationExit').val(data[2][0].observation_it);
                    $('#subCustomerExit').val(data[2][0].customer_id);
                    $('#conditionExit').val(data[2][0].condition_id);
                    $('#statusExit').val(data[2][0].status_id);
                    $('#shipmentExit').val(data[2][0].shipment_id);
                    $('#employeeExit').val(data[2][0].employee_id);
                },
                error: function(data){
                    $('#editItemOpen').modal('hide');
                    $('#alertDanger').html('<div class="alert alert-danger alert-dismissible fade show" role="alert">¡Information not available!<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
                }
            });
            $('#editItemClose').modal('show');
            $('#idItemInputInfo').val(idItem);
            $('#itemIdExitInfo').val(idItem);
        }

        function updateItemOpen(){
            $.ajax({
                headers: {'X-CSRF-TOKEN': $('input[name=_token]').val()},
                type: "POST",
                url: 'update-item/'+$('#idItemEdit').val(),
                data: $('form#updateItemOpen').serialize(),
                success: function(data){
                    console.log(data)
                    $('#editItemOpen').modal('hide');
                    $('#dtItems').DataTable().ajax.reload();
                    $('#alertSuccess').html('<div class="alert alert-success alert-dismissible fade show" role="alert">¡The item has been successfully edited!<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
                },
                error: function(data){
                    console.log(data)
                    $('#editItemOpen').modal('hide');
                    $('#dtItems').DataTable().ajax.reload();
                    $('#alertDanger').html('<div class="alert alert-danger alert-dismissible fade show" role="alert"><ul id="listAlert"></ul><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
                    var resultado = data.responseJSON.errors;
                    var contenido = '';
                    $.each(resultado, function(index, value) {
                        contenido += '<li>'+value+'</li>';
                    });
                    $("#listAlert").html(contenido);
                }
            });
        }

        function updateInputInfo(){
            $.ajax({
                headers: {'X-CSRF-TOKEN': $('input[name=_token]').val()},
                type: "POST",
                url: 'update-item/'+$('#idItemInpu').val(),
                data: $('form#updateInputInfo').serialize(),
                success: function(data){
                    console.log(data)
                    $('#editItemClose').modal('hide');
                    $('#dtItems').DataTable().ajax.reload();
                    $('#alertSuccess').html('<div class="alert alert-success alert-dismissible fade show" role="alert">¡The item has been successfully edited!<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
                },
                error: function(data){
                    console.log(data)
                    $('#editItemClose').modal('hide');
                    $('#dtItems').DataTable().ajax.reload();
                    $('#alertDanger').html('<div class="alert alert-danger alert-dismissible fade show" role="alert"><ul id="listAlert"></ul><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
                    var resultado = data.responseJSON.errors;
                    var contenido = '';
                    $.each(resultado, function(index, value) {
                        contenido += '<li>'+value+'</li>';
                    });
                    $("#listAlert").html(contenido);
                }
            });
        }

        function updateExitInfo(){
            $.ajax({
                headers: {'X-CSRF-TOKEN': $('input[name=_token]').val()},
                type: "POST",
                url: 'update-item/'+$('#itemIdExitInfo').val(),
                data: $('form#updateExitInfo').serialize(),
                success: function(data){
                    console.log(data)
                    $('#editItemClose').modal('hide');
                    $('#dtItems').DataTable().ajax.reload();
                    $('#alertSuccess').html('<div class="alert alert-success alert-dismissible fade show" role="alert">¡The item has been successfully edited!<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
                },
                error: function(data){
                    console.log(data)
                    $('#editItemClose').modal('hide');
                    $('#dtItems').DataTable().ajax.reload();
                    $('#alertDanger').html('<div class="alert alert-danger alert-dismissible fade show" role="alert"><ul id="listAlert"></ul><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
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
                    $('#alertSuccess').html('<div class="alert alert-success alert-dismissible fade show" role="alert">¡The item has been successfully deleted!<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
                },
                error: function(data){
                    $('#deleteItem').modal('hide');
                    $('#dtItems').DataTable().ajax.reload();
                    $('#alertDanger').html('<div class="alert alert-danger alert-dismissible fade show" role="alert">¡Information not available!<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
                }
            });
        }

        function openClose(idItem){
            $.ajax({
                type: "GET",
                url: 'consult-item/'+idItem,
                success: function(data){
                    console.log(data);
                    var customer = data[1][0].customer_id;
                },
                error: function(data){
                    $('#editItemOpen').modal('hide');
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
                    $('#alertSuccess').html('<div class="alert alert-success alert-dismissible fade show" role="alert">¡The item has been successfully closed!<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
                },
                error: function(data){
                    $('#closeItem').modal('hide');
                    $('#dtItems').DataTable().ajax.reload();
                    $('#alertDanger').html('<div class="alert alert-danger alert-dismissible fade show" role="alert"><ul id="listAlert"></ul><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
                    var resultado = data.responseJSON.errors;
                    var contenido = '';
                    $.each(resultado, function(index, value) {
                        contenido += '<li>'+value+'</li>';
                    });
                    $("#listAlert").html(contenido);
                }
            });
        }
    </script>
@stop
