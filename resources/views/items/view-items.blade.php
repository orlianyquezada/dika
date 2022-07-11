@extends('adminlte::page')

@section('title', 'Items')

@section('content_header')
    <!-- Container's info -->
    <div class="mt-3">
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
    <div class="">
        <!-- Items's table -->
        <div class="card border-white shadow">
            <div class="card-body">
                <table class="table table-striped table-bordered dt-responsive nowrap dataTable_width_auto display" id="dtItems" style="width:100%">
                    <thead>
                        <tr>
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
                                <div class="col-12">
                                    <div class="form-group">
                                        <label for="ubicationInsert">Ubication</label>
                                        <input type="text" name="ubication_it" id="ubicationInsert" class="form-control shadow-sm" placeholder="Ubication">
                                    </div>
                                </div>
                                <div class="col-sm-12 col-lg-4">
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
                                <div class="col-sm-12 col-lg-4">
                                    <div class="form-group">
                                        <label for="statusInsert">Status</label>
                                        <select name="status_id" id="statusInsert" class="form-control shadow-sm">
                                            <option value="">Select an option</option>
                                            @foreach ($status as $statu)
                                                @if ($statu->status_st == 'Entry')
                                                    <option value="{{ $statu->id }}">{{ $statu->status_st }}</option>
                                                @endif
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-sm-12 col-lg-4">
                                    <div class="form-group">
                                        <label for="vendorBrandInsert">Vendor/Brand</label>
                                        <select name="customer_id" class="form-control shadow-sm">
                                            <option value="" selected disabled>Select an option</option>
                                            @foreach ($customers as $customer)
                                                <option value="{{ $customer->id }}">{{ $customer->name_cu }}</option>
                                            @endforeach
                                        </select>
                                    </div>
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
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label for="observationInputConsult">Observation of entry</label>
                                    <textarea name="observation_it" id="observationInputConsult" cols="12" rows="2" class="form-control shadow-sm" placeholder="Observation"></textarea>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-12 col-lg-4">
                                <div class="form-group">
                                    <label for="vendorBrandConsult">Vendor/Brand</label>
                                    <input type="text" name="customer_id" id="vendorBrandConsult" class="form-control shadow-sm">
                                </div>
                            </div>
                            <div class="col-sm-12 col-lg-4">
                                <div class="form-group">
                                    <label for="customerConsult">Customer</label>
                                    <input type="text" name="customer_id" id="customerConsult" readonly class="form-control shadow-sm">
                                </div>
                            </div>
                            <div class="col-sm-12 col-lg-4">
                                <div class="form-group">
                                    <label for="employeeExitConsult">Employee</label>
                                    <input type="text" name="employee_id" id="employeeExitConsult" readonly class="form-control shadow-sm">
                                </div>
                            </div>
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
                                    <input type="text" name="shipment_id" id="shipmentExitConsult" readonly class="form-control shadow-sm">
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
        <div class="modal fade" id="editItemOpen" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="editItemOpenLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-scrollable modal-xl">
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
                                        <label for="datimeEdit">Date and time</label>
                                        <div class="input-group date" id="datetimepicker1" data-target-input="nearest">
                                            <input type="text" class="form-control datetimepicker-input" data-target="#datetimepicker1" id="datetimeEdit" name="datetime_it"/>
                                            <div class="input-group-append" data-target="#datetimepicker1" data-toggle="datetimepicker">
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
                                <div class="col-sm-12 col-lg-4">
                                    <div class="form-group">
                                        <label for="customerPrimEdit">Customers</label>
                                        <select name="customer_id" id="customerPrimEdit" class="form-control shadow-sm">
                                            @foreach ($customers as $customer)
                                                <option value="{{ $customer->id }}">{{ $customer->name_cu }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-12 col-lg-2">
                                    <div class="form-group">
                                        <label for="conditionEdit">Conditions</label>
                                        <select name="condition_id" id="conditionEdit" class="form-control shadow-sm">
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
                        <div id="alertDangerUpdate"></div>
                        <div id="alertSuccessUpdate"></div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" form="updateItemOpen" class="btn btn-warning" onclick="updateItemOpen();">Update</button>
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
                            <input type="hidden" name="item_id" id="idItemClose">
                            <input type="hidden" name="user_id" value="{{ Auth::user()->id }}">
                            <input type="hidden" name="datetime_exit_it" id="datetimeClose" value="@php date_default_timezone_set('America/Caracas'); echo $DateAndTime = date('Y-m-d H:i:s', time()); @endphp ">
                            <div class="row">
                                <div class="col-12 col-lg-5">
                                    <div class="form-group">
                                        <label for="address_it">Address</label>
                                        <input type="text" name="address_it" id="address_it" class="form-control shadow-sm" placeholder="Address">
                                    </div>
                                </div>
                                <div class="col-sm-12 col-lg-4">
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
                                                @if ($statu->status_st == 'Entry') @continue @endif
                                                <option value="{{ $statu->id }}">{{ $statu->status_st }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-12 col-lg-4">
                                    <div class="form-group">
                                        <label for="vendorBrandClose">Vendor/Brand</label>
                                        <input type="text" name="customer_id" id="vendorBrandClose" readonly class="form-control shadow-sm">
                                    </div>
                                </div>
                                <div class="col-sm-12 col-lg-4">
                                    <div class="form-group">
                                        <label for="customerClose">Customer</label>
                                        <select name="sub_customer_id" id="customerClose" class="form-control shadow-sm customerDinamico">
                                            <option value="">Select an opcion</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-sm-12 col-lg-4">
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
                                <label for="observationExitIt">Observation</label>
                                <textarea name="observation_exit_it" id="observationExitIt" cols="12" rows="2" class="form-control shadow-sm" placeholder="Observation"></textarea>
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
                defaultDate: $('#datetimeInput').val(),
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
                defaultDate: new Date(),
                format: 'YYYY-MM-DD HH:mm:ss'
            });
        });

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
                    $('#vendorBrandInsert').val('');
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
                    $('#conditionInputConsult').val(data[3]).prop('disabled', true);
                    $('#statusInputConsult').val(data[4]).prop('disabled', true);
                    $('#vendorBrandConsult').val(data[1].name_cu).prop('disabled', true);
                    $('#observationInputConsult').val(data[0].observation_input_it).prop('disabled', true);
                    $('#datetimeExitConsult').val(data[0].datetime_exit_it).prop('disabled', true);
                    $('#addressConsult').val(data[0].address_it).prop('disabled', true);
                    $('#observationExitConsult').val(data[0].observation_exit_it).prop('disabled', true);

                    if (data[2]) 
                        $('#customerConsult').val(data[2].name_cu).prop('disabled', true);
                    
                    if (data[5]) 
                        $('#shipmentExitConsult').val(data[5].shipment_sh).prop('disabled', true);
                    
                    if (data[6])
                        $('#employeeExitConsult').val(data[6].name).prop('disabled', true);
                },
                error: function(data){
                    console.log(data);
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
                    var status = data[0];
                    if (status == 'close'){
                        itemClose(idItem);
                    }else if (status == 'open'){
                        itemOpen(idItem);
                    }
                },
                error: function(data){
                    $('#alertDanger').empty();
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
                    $('#alertDanger').empty();
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
                    $('#subCustomerExit').val(data[2][0].sub_customer_id);
                    $('#conditionExit').val(data[2][0].condition_id);
                    $('#statusExit').val(data[2][0].status_id);
                    $('#shipmentExit').val(data[2][0].shipment_id);
                    $('#employeeExit').val(data[2][0].employee_id);
                    subCustomersDinamicos(data[1][0].customer_id,data[2][0].sub_customer_id);
                },
                error: function(data){
                    $('#editItemOpen').modal('hide');
                    $('#alertDanger').empty();
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
                    $('#editItemOpen').modal('hide');
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

        function updateInputInfo(){
            $.ajax({
                headers: {'X-CSRF-TOKEN': $('input[name=_token]').val()},
                type: "POST",
                url: 'update-item/'+$('#idItemInpu').val(),
                data: $('form#updateInputInfo').serialize(),
                success: function(data){
                    $('#dtItems').DataTable().ajax.reload();
                    $('#alertSuccessInput').empty();
                    $('#alertSuccessInput').html('<div class="alert alert-success alert-dismissible fade show" role="alert">¡The item has been successfully edited!<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
                },
                error: function(data){
                    $('#alertDangerInput').empty();
                    $('#alertDangerInput').html('<div class="alert alert-danger alert-dismissible fade show" role="alert"><ul id="listAlert"></ul><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
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
                    $('#dtItems').DataTable().ajax.reload();
                    $('#alertSuccessExit').empty();
                    $('#alertSuccessExit').html('<div class="alert alert-success alert-dismissible fade show" role="alert">¡The item has been successfully edited!<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
                },
                error: function(data){
                    $('#alertDangerExit').empty();
                    $('#alertDangerExit').html('<div class="alert alert-danger alert-dismissible fade show" role="alert"><ul id="listAlert"></ul><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
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
                    console.log(data)
                    document.querySelectorAll('#employeeClose option').forEach(element => {
                        if (data[6]) {
                            if (element.value == data[6].id) {
                                element.setAttribute('selected', 'true')
                            }
                        }
                    });

                    document.querySelectorAll('#statusClose option').forEach(element => {
                        if (data[4]) {
                            if (element.value == data[4].id) {
                                element.setAttribute('selected', 'true')
                            }
                        }
                    });

                    document.querySelectorAll('#shipmentClose option').forEach(element => {
                        if (data[0]) {
                            if (element.value == data[0].shipment_id) {
                                element.setAttribute('selected', 'true')
                            }
                        }
                    });

                    $('#address_it').val(data[0].address_it);
                    $('#vendorBrandClose').val(data[1].name_cu).prop('disabled',true);
                    $('#observationExitIt').val(data[0].observation_exit_it);
                    subCustomersDinamicos(data[1].id, data[0].sub_customer_id);
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

        function subCustomersDinamicos(customer, subcustomer = null){
            $.ajax({
                type: "GET",
                url: 'consult-sub-customer/'+customer,
                success: function(data){
                    if (data.length) {
                        let contenido = '<option value="">Select an opcion</option>';
                        
                        for (let i=0; i<data.length; i++) {
                            contenido += '<option value="'+data[i].id+'">'+data[i].name_cu+'</option>';
                        }  
                        $(".customerDinamico").html(contenido);
                    }

                    if (subcustomer){
                        document.querySelectorAll('#customerClose option').forEach(element => {
                            if (element.value == subcustomer) {
                                element.setAttribute('selected', 'true')
                            }
                        });
                    }

                    
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
            $('#customerInsert').val('');
            $('#conditionInsert').val('');
            $('#statusInsert').val('');
            $('#observationInsert').val('');
            $('.alertDangerModal').empty();
            $('#alertDangerUpdate').empty();
            $('#alertDangerUpdate').empty();
            $('#alertSuccessInput').empty();
            $('#alertDangerInput').empty();
            $('#alertSuccessExit').empty();
            $('#alertDangerExit').empty();
            $('#addressClose').val('');
            $('#conditionClose').val('');
            $('#employeeClose').val('');
            $('#statusClose').val('');
            $('#shipementClose').val('');
            $('#observationClose').val('');
            $('#alertDangerClose').empty();
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

    <script>
        let table = $('#dtItems').DataTable({
            serverSide: true,
            dom: 'Bfrtip',
            buttons: ['excel'],
            ajax:{
                    url: 'all-items',
                    method: "GET",
            },
            bSort: true,
            order: [],
            destroy: true,
            columns: [
                { data: "datetime_input_it" },
                { data: "customer", name: "customers.name_cu"},
                { data: "item_it" },
                { data: "subcustomer", name: "customers.name_cu"},
                { data: "quanty_it" },
                { data: "qty_boxes_it" },
                { data: "ubication" },
                { data: "condition", name: "conditions.condition_co"},
                { data: "status", name: "status.status_st" },
                { data: "shipment", name: "shipments.shipment_sh" },
                { data: "address_it" },
                { data: 'actions', name: 'actions', orderable: false, searchable: false }
            ],
            language: {
                url: "//cdn.datatables.net/plug-ins/1.10.19/i18n/Spanish.json",
            }, 
        });

    </script>
@stop
