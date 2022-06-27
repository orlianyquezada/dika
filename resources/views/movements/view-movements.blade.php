@extends('adminlte::page')

@section('title', 'Movements')

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
                    <div class="col-12 col-lg-3">
                        <h3><strong>Movements</strong></h3>
                    </div>
                    <div class="col-12 col-lg-3">
                        <!-- customer registration button -->
                        <button type="button" class="btn btn-warning shadow-sm w-100" data-toggle="modal" data-target="#insertMovement">
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
        <div class="card border-white shadow">
            <div class="card-body">
                <table class="table table-striped table-bordered dt-responsive nowrap" id="dtMovements">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Date</th>
                            <th>Vendor/Brand</th>
                            <th>Item</th>
                            <th>Quanty</th>
                            <th>Qty boxes</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Modal's insert -->
        <div class="modal fade" id="insertMovement" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="insertMovementLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-scrollable">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="insertMovementLabel"><strong>Movement Registration</strong></h5>
                    </div>
                    <div class="modal-body">
                        <form action="{{ route('movement-register') }}" method="post" id="movementRegister" autocomplete="off">
                            @csrf
                            <input type="hidden" name="datetime_inm" id="datetimeInsert" value="@php date_default_timezone_set('America/Caracas'); echo $DateAndTime = date('Y-m-d H:i:s', time()); @endphp ">
                            <input type="hidden" name="user_id" value="1">
                            <div class="form-group">
                                <label for="itemInsert">Item</label>
                                <input type="text" name="item_inm" id="itemInsert" class="form-control shadow-sm" placeholder="Item">
                            </div>
                            <div class="row">
                                <div class="col-12 col-lg-6">
                                    <div class="form-group">
                                        <label for="quantyInsert">Quanty</label>
                                        <input type="number" name="quanty_inm" id="quantyInsert" class="form-control shadow-sm" placeholder="Quanty">
                                    </div>
                                </div>
                                <div class="col-12 col-lg-6">
                                    <div class="form-group">
                                        <label for="qty_boxesInsert">Quanty boxes</label>
                                        <input type="number" name="qty_boxes_inm" id="qty_boxesInsert" class="form-control shadow-sm" placeholder="Quanty boxes">
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="ubicationInsert">Ubication</label>
                                <input type="text" name="ubication_inm" id="ubicationInsert" class="form-control shadow-sm" placeholder="Ubication">
                            </div>
                            <div class="form-group">
                                <label for="customer_id">Customers</label>
                                <select name="customer_id" id="customer_id" class="form-control shadow-sm">
                                    <option value="">Select an option</option>
                                    @foreach ($customers as $customer)
                                        <option value="{{ $customer->id }}">{{ $customer->name_cu }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="conditionInsert">Conditions</label>
                                <select name="condition_id" id="conditionInsert" class="form-control shadow-sm">
                                    <option value="">Select an option</option>
                                    @foreach ($conditions as $condition)
                                        <option value="{{ $condition->id }}">{{ $condition->condition_co }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="statusInsert">Status</label>
                                <select name="status_id" id="statusInsert" class="form-control shadow-sm">
                                    <option value="">Select an option</option>
                                    @foreach ($status as $statu)
                                        <option value="{{ $statu->id }}">{{ $statu->status_st }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="observationInsert">Observation</label>
                                <textarea name="observation_inm" id="observationInsert" cols="12" rows="2" class="form-control shadow-sm" placeholder="Observation"></textarea>
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

        <!-- Modal's consult -->
        <div class="modal fade" id="consultMovement" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="consultMovementLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-scrollable">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="consultMovementLabel"><strong>Movement Consult</strong></h5>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="itemConsult">Item</label>
                            <input type="text" name="item_mo" id="itemConsult" class="form-control shadow-sm">
                        </div>
                        <div class="row">
                            <div class="col-12 col-lg-6">
                                <div class="form-group">
                                    <label for="quantyConsult">Quanty</label>
                                    <input type="number" name="quanty_mo" id="quantyConsult" class="form-control shadow-sm">
                                </div>
                            </div>
                            <div class="col-12 col-lg-6">
                                <div class="form-group">
                                    <label for="qtyBoxesConsult">Quanty boxes</label>
                                    <input type="number" name="qty_boxes_mo" id="qtyBoxesConsult" class="form-control shadow-sm">
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="ubicationConsult">Ubication</label>
                            <input type="text" name="ubication_mo" id="ubicationConsult" class="form-control shadow-sm">
                        </div>
                        <div class="form-group">
                            <label for="customerPrimConsult">Customers</label>
                            <input type="text" name="customer_id" id="customerPrimConsult" class="form-control shadow-sm">
                        </div>
                        <div class="form-group">
                            <label for="conditionsConsult">Conditions</label>
                            <input type="text" name="condition_id" id="conditionsConsult" class="form-control shadow-sm">
                        </div>
                        <div class="form-group">
                            <label for="statusConsult">Status</label>
                            <input type="text" name="status_id" id="statusConsult" class="form-control shadow-sm">
                        </div>
                        <div class="form-group">
                            <label for="observationConsult">Observation</label>
                            <textarea name="observation_mo" id="observationConsult" cols="12" rows="2" class="form-control shadow-sm" placeholder="Observation"></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-outline-secondary" data-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal's update -->
        <div class="modal fade" id="editMovement" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="editMovementLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-scrollable">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="editMovementLabel"><strong>Movement edit</strong></h5>
                    </div>
                    <div class="modal-body">
                        <form id="updateMovement" autocomplete="off">
                            <input type="hidden" name="_token" id="token" value="{{ csrf_token() }}">
                            <input type="hidden" name="user_id" value="1">
                            <input type="hidden" name="id" id="idMovementEdit">
                            <input type="hidden" name="datetime_inm" id="dateEdit">
                            <div class="form-group">
                                <label for="item_mo">Item</label>
                                <input type="text" name="item_inm" id="itemEdit" class="form-control shadow-sm" placeholder="Item">
                            </div>
                            <div class="row">
                                <div class="col-12 col-lg-6">
                                    <div class="form-group">
                                        <label for="quanty_mo">Quanty</label>
                                        <input type="number" name="quanty_inm" id="quantyEdit" class="form-control shadow-sm" placeholder="Quanty">
                                    </div>
                                </div>
                                <div class="col-12 col-lg-6">
                                    <div class="form-group">
                                        <label for="qty_boxes_mo">Quanty boxes</label>
                                        <input type="number" name="qty_boxes_inm" id="qtyBoxesEdit" class="form-control shadow-sm" placeholder="Quanty boxes">
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="ubication_mo">Ubication</label>
                                <input type="text" name="ubication_inm" id="ubicationEdit" class="form-control shadow-sm" placeholder="Ubication">
                            </div>
                            <div class="form-group">
                                <label for="customer_id">Customers</label>
                                <select name="customer_id" id="customerPrimEdit" class="form-control shadow-sm">
                                    @foreach ($customers as $customer)
                                        <option value="{{ $customer->id }}">{{ $customer->name_cu }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="condition_id">Conditions</label>
                                <select name="condition_id" id="conditionEdit" class="form-control shadow-sm">
                                    @foreach ($conditions as $condition)
                                        <option value="{{ $condition->id }}">{{ $condition->condition_co }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="status_id">Status</label>
                                <select name="status_id" id="statusEdit" class="form-control shadow-sm">
                                    @foreach ($status as $statu)
                                        <option value="{{ $statu->id }}">{{ $statu->status_st }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="observation_mo">Observation</label>
                                <textarea name="observation_inm" id="observationEdit" cols="12" rows="2" class="form-control shadow-sm" placeholder="Observation"></textarea>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" form="updateMovement" class="btn btn-warning" onclick="updateMovement();">Update</button>
                        <button type="button" class="btn btn-outline-secondary" data-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal's delete -->
        <div class="modal fade" id="deleteMovement" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="deleteMovementLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="deleteMovementLabel"><strong>Delete Movement</strong></h5>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" id="idMovementDelete">
                        <p class="lead">Do you want to delete the movement?</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" id="btnDelete" class="btn btn-warning" onclick="confirmDelete();">Delete</button>
                        <button type="button" class="btn btn-outline-secondary" data-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>

        {{-- <!-- Modal's close -->
        <div class="modal fade" id="closeMovement" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="closeMovementLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="closeMovementLabel"><strong>Close Movement</strong></h5>
                    </div>
                    <div class="modal-body">
                        <form action="{{ route('movements-register') }}" id="movementClose" method="post" autocomplete="off">
                            @csrf
                            <input type="hidden" name="movement_id" id="idMovementClose">
                            <input type="hidden" name="user_id" value="1">
                            <input type="hidden" name="date_mo" id="date" value="@php date_default_timezone_set('America/Caracas'); echo $DateAndTime = date('Y-m-d H:i:s', time()); @endphp ">
                            <div class="row">
                                <div class="col-12 col-lg-6">
                                    <div class="form-group">
                                        <label for="shipmentClose">Shipment</label>
                                        <select name="shipment_id" id="shipmentClose" class="form-control shadow-sm">
                                            @foreach ($shipments as $shipment)
                                                <option value="{{ $shipment->id }}">{{ $shipment->shipment_sh }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-12 col-lg-6">
                                    <div class="form-group">
                                        <label for="employeeClose">Employee</label>
                                        <select name="employee_id" id="employeeClose" class="form-control shadow-sm">
                                            @foreach ($users as $user)
                                                <option value="{{ $user->id }}">{{ $user->name }}</option> 
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-12 col-lg-6">
                                    <div class="form-group">
                                        <label for="customerClose">Customers</label>
                                        <select name="customer_id" id="customerClose" class="form-control shadow-sm">
                                            @foreach ($customers as $customer)
                                                <option value="{{ $customer->id }}">{{ $customer->name_cu }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-12 col-lg-6">
                                    <div class="form-group">
                                        <label for="statusClose">Status</label>
                                        <select name="status_id" id="statusClose" class="form-control shadow-sm">
                                            @foreach ($status as $statu)
                                                <option value="{{ $statu->id }}">{{ $statu->status_st }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-12 col-lg-6">
                                    <div class="form-group">
                                        <label for="conditionClose">Conditions</label>
                                        <select name="condition_id" id="conditionClose" class="form-control shadow-sm">
                                            @foreach ($conditions as $condition)
                                                <option value="{{ $condition->id }}">{{ $condition->condition_co }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="ubicationClose">Ubication</label>
                                <input type="text" name="ubication_mo" id="ubicationClose" class="form-control shadow-sm" placeholder="Ubication">
                            </div>
                            <div class="form-group">
                                <label for="observationClose">Observation</label>
                                <textarea name="observation_mo" id="observationClose" cols="12" rows="2" class="form-control shadow-sm" placeholder="Observation"></textarea>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" id="btnClose" form="movementClose" class="btn btn-warning">Close</button>
                        <button type="button" class="btn btn-outline-secondary" data-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div> --}}
    </div>
@stop

@section('css')
    <link rel="stylesheet" href="/css/admin_custom.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.2/css/bootstrap.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.3.0/css/responsive.bootstrap4.min.css">
@stop

@section('js')
    <script src="https://cdn.datatables.net/responsive/2.3.0/js/dataTables.responsive.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.3.0/js/responsive.bootstrap4.min.js"></script>
    <script>
        $(document).ready( function () {
            $('#dtMovements').DataTable({
                responsive: true,
                autoWidth: false,
                ajax:{
                    url: 'all-movements',
                    method: "GET",
                },
                columns:[
                    {data: 'id'},
                    {data: 'datetime_inm'},
                    {data: 'name_cu'},
                    {data: 'item_inm'},
                    {data: 'quanty_inm'},
                    {data: 'qty_boxes_inm'},
                    {data: 'status_st'},
                    {data: 'id',
                    render: function(data,t,w,meta){
                        return '<div class="btn-group btn-group-sm justify-content-end" role="group" aria-label=""><button onclick="consultMovement('+data+');" class="btn btn-xs btn-ligth text-dark" title="Edit"><i class="fa fa-fw fa-eye"></i></button><button onclick="editMovement('+data+');" class="btn btn-xs btn-ligth text-dark" title="Edit"><i class="fa fa-fw fa-pen"></i></button><button class="btn btn-xs btn-ligth text-dark" title="Delete" onclick="deleteMovement('+data+')"><i class="fa fa-fw fa-trash"></i></button><button class="btn btn-xs btn-ligth text-dark" title="Close" onclick="closeMovement('+data+');"><i class="fa fa-fw fa-lock"></i></button></div>';
                    }}
                ]
            });
        } );

        function consultMovement(idMovement){
            $.ajax({
                type: "GET",
                url: 'view-movement/'+idMovement,
                success: function(data){
                    $('#itemConsult').val(data[0].item_inm).prop('disabled', true);
                    $('#quantyConsult').val(data[0].quanty_inm).prop('disabled', true);
                    $('#qtyBoxesConsult').val(data[0].qty_boxes_inm).prop('disabled', true);
                    $('#ubicationConsult').val(data[0].ubication_inm).prop('disabled', true);
                    $('#observationConsult').val(data[0].observation_inm).prop('disabled', true);
                    $('#customerPrimConsult').val(data[0].name_cu).prop('disabled', true);
                    $('#conditionsConsult').val(data[0].condition_co).prop('disabled', true);
                    $('#statusConsult').val(data[0].status_st).prop('disabled', true);
                },
                error: function(data){
                    $('#consultMovement').modal('hide');
                    $('#alertDanger').append('<div id="messageAlertDanger"></div>');
                    $('#messageAlertDanger').addClass('alert alert-danger alert-dismissible fade show');
                    $('#messageAlertDanger').text('¡Information not available!');
                    $('#messageAlertDanger').append('<button type="button" id="dimissibleAlertDanger" data-dismiss="alert" aria-label="Close"></button>');
                    $('#dimissibleAlertDanger').addClass('close');
                    $('#dimissibleAlertDanger').append('<span aria-hidden="true">&times;</span>');
                }
            });
            $('#consultMovement').modal('show');
        }

        function editMovement(idMovement){
            $.ajax({
                type: "GET",
                url: 'view-movement/'+idMovement,
                success: function(data){
                    $('#itemEdit').val(data[0].item_inm);
                    $('#quantyEdit').val(data[0].quanty_inm);
                    $('#qtyBoxesEdit').val(data[0].qty_boxes_inm);
                    $('#ubicationEdit').val(data[0].ubication_inm);
                    $('#observationEdit').val(data[0].observation_inm);
                    $('#customerPrimEdit').val(data[0].customer_id);
                    $('#conditionEdit').val(data[0].condition_id);
                    $('#statusEdit').val(data[0].status_id);
                    $('#idMovementEdit').val(data[0].id);
                    $('#dateEdit').val(data[0].datetime_inm);
                },
                error: function(data){
                    $('#editMovement').modal('hide');
                    $('#alertDanger').append('<div id="messageAlertDanger"></div>');
                    $('#messageAlertDanger').addClass('alert alert-danger alert-dismissible fade show');
                    $('#messageAlertDanger').text('¡Information not available!');
                    $('#messageAlertDanger').append('<button type="button" id="dimissibleAlertDanger" data-dismiss="alert" aria-label="Close"></button>');
                    $('#dimissibleAlertDanger').addClass('close');
                    $('#dimissibleAlertDanger').append('<span aria-hidden="true">&times;</span>');
                }
            });
            $('#editMovement').modal('show');
        }

        function updateMovement(){
            $.ajax({
                headers: {'X-CSRF-TOKEN': $('input[name=_token]').val()},
                type: "POST",
                url: +$('#idMovementEdit').val(),
                data: $('form#updateMovement').serialize(),
                error: function(data){
                    console.log(data.responseJSON);
                    $('#editMovement').modal('hide');
                    $('#dtMovements').DataTable().ajax.reload();
                    $('#alertDanger').append('<div id="messageAlertDanger"></div>');
                    $('#messageAlertDanger').addClass('alert alert-danger alert-dismissible fade show');
                    $('#messageAlertDanger').append('<ul id="listAlert"></ul>');
                    var resultado = data.responseJSON.errors;
                    var contenido = '';
                    $.each(resultado, function(index, value) {
                        contenido += '<li>'+value+'</li>';
                    });
                    $("#listAlert").html(contenido);
                    $('#messageAlertDanger').append('<button type="button" id="dimissibleAlertDanger" data-dismiss="alert" aria-label="Close"></button>');
                    $('#dimissibleAlertDanger').addClass('close');
                    $('#dimissibleAlertDanger').append('<span aria-hidden="true">&times;</span>');
                },
                success: function(data){
                    $('#editMovement').modal('hide');
                    $('#dtMovements').DataTable().ajax.reload();
                    $('#alertSuccess').append('<div id="messageAlertSuccess"></div>');
                    $('#messageAlertSuccess').text('¡The movement has been successfully edited!');
                    $('#messageAlertSuccess').addClass('alert alert-success alert-dismissible fade show');
                    $('#messageAlertSuccess').append('<button type="button" id="dimissibleAlertSuccess" data-dismiss="alert" aria-label="Close"></button>');
                    $('#dimissibleAlertSuccess').addClass('close');
                    $('#dimissibleAlertSuccess').append('<span aria-hidden="true">&times;</span>');
                }
            });
        }

        function deleteMovement(idMovement){
            $('#idMovementDelete').val(idMovement);
            $('#deleteMovement').modal('show');
        }

        function confirmDelete(){
            $.ajax({
                type: "GET",
                url: 'delete-movement/'+$('#idMovementDelete').val(),
                error: function(data){
                    $('#deleteMovement').modal('hide');
                    $('#dtMovements').DataTable().ajax.reload();
                    $('#alertDanger').append('<div id="messageAlertDanger"></div>');
                    $('#messageAlertDanger').addClass('alert alert-danger alert-dismissible fade show');
                    $('#messageAlertDanger').text('¡Information not available!');
                    $('#messageAlertDanger').append('<button type="button" id="dimissibleAlertDanger" data-dismiss="alert" aria-label="Close"></button>');
                    $('#dimissibleAlertDanger').addClass('close');
                    $('#dimissibleAlertDanger').append('<span aria-hidden="true">&times;</span>');
                },
                success: function(data){
                    $('#deleteMovement').modal('hide');
                    $('#dtMovements').DataTable().ajax.reload();
                    $('#alertSuccess').html('<div class="alert alert-success alert-dismissible fade show" role="alert">¡The movement has been successfully deleted!<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
                }
            });
        }

        // function closeMovement(idMovement){
        //     $.ajax({
        //         type: "GET",
        //         url: 'viewMovement/'+idMovement,
        //         success: function(data){
        //             $("#customerClose option[value='"+data[0].customer_id+"']").prop("disabled",true);
        //         },
        //         error: function(data){
        //             $('#consultMovement').modal('hide');
        //             $('#alertDanger').append('<div id="messageAlertDanger"></div>');
        //             $('#messageAlertDanger').addClass('alert alert-danger alert-dismissible fade show');
        //             $('#messageAlertDanger').text('¡Information not available!');
        //             $('#messageAlertDanger').append('<button type="button" id="dimissibleAlertDanger" data-dismiss="alert" aria-label="Close"></button>');
        //             $('#dimissibleAlertDanger').addClass('close');
        //             $('#dimissibleAlertDanger').append('<span aria-hidden="true">&times;</span>');
        //         }
        //     });
        //     $('#idMovementClose').val(idMovement);
        //     $('#closeMovement').modal('show');
        // }
    </script>
@stop