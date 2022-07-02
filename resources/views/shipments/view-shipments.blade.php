@extends('adminlte::page')

@section('title', 'Shipments')

@section('content_header')
    <!-- Container's info -->
    <div class="container mt-3 col-lg-8">
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
                    <div class="col-12 col-lg-6">
                        <h3><strong>Shipments</strong></h3>
                    </div>
                    <div class="col-12 col-lg-6">
                        <!-- shipment register button -->
                        <button type="button" class="btn btn-warning shadow-sm w-100" data-toggle="modal" data-target="#insertShipments">
                            <strong>Register</strong>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop

@section('content')
    <div class="container col-lg-8">
        <!-- Shipment's table -->
        <div class="card shadow border-white">
           <div class="card-body">
                <table class="table table-hover dt-responsive nowrap display dataTable_width_auto" id="dtShipments" style="width:100%">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody></tbody>
                </table>
            </div>
        </div>

        <!-- Modal's insert -->
        <div class="modal fade" id="insertShipments" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="insertShipmentsLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header bg-warning">
                        <h5 class="modal-title" id="insertShipmentsLabel"><strong>Shipment Register</strong></h5>
                    </div>
                    <div class="modal-body">
                        <form action="{{ route('shipment-register') }}" method="post" autocomplete="off" id="shipmentRegister">
                            @csrf
                            <div class="form-group">
                                <label for="name">Name</label>
                                <input type="text" name="shipment_sh" id="name" class="form-control shadow-sm" placeholder="Name">
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" form="shipmentRegister" class="btn btn-warning">Save</button>
                        <button type="button" class="btn btn-outline-secondary" data-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal's update -->
        <div class="modal fade" id="editShipment" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="editShipmentLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header bg-warning">
                        <h5 class="modal-title" id="editShipmentLabel"><strong>Edit Shipment</strong></h5>
                    </div>
                    <div class="modal-body">
                        <form id="updateShipment" autocomplete="off">
                            <input type="hidden" name="id" id="idShipmentEdit">
                            <input type="hidden" name="_token" id="token" value="{{ csrf_token() }}">
                            <div class="form-group">
                                <label for="nameEdit">Name</label>
                                <input type="text" id="nameEdit" name="shipment_sh" class="form-control shadow-sm">
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" id="btnEdit" form="updateShipment" class="btn btn-warning shadow-sm" onclick="updateShipment();">Update</button>
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
    <script>
        $(document).ready( function () {
            $('#dtShipments').DataTable({
                responsive: true,
                autoWidth: false,
                ajax:{
                    url: 'all-shipments',
                    method: "GET",
                },
                columns:[
                    {data: 'shipment_sh'},
                    {width: "10%", orderable: false, data: 'id',
                    render: function(data,t,w,meta){
                        return '<div class="btn-group btn-group-sm justify-content-end" role="group" aria-label=""><button onclick="editShipment('+data+');" class="btn btn-xs btn-ligth text-dark" title="Edit"><i class="fa fa-fw fa-pen"></i></button></div>';
                    }}
                ]
            });
        } );

        function editShipment(idShipment){
            $.ajax({
                type: "GET",
                url: 'consult-shipment/'+idShipment,
                success: function(data){
                    $('#nameEdit').val(data.shipment_sh);
                    $('#idShipmentEdit').val(data.id);
                },
                error: function(data){
                    $('#editShipment').modal('hide');
                    $('#alertDanger').html('<div class="alert alert-danger alert-dismissible fade show" role="alert">¡Information not available!<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
                }
            });
            $('#editShipment').modal('show');
        }

        function updateShipment(){
            $.ajax({
                headers: {'X-CSRF-TOKEN': $('input[name=_token]').val()},
                type: "POST",
                url: 'update-shipment/'+$('#idShipmentEdit').val(),
                data: $('form#updateShipment').serialize(),
                error: function(data){
                    $('#editShipment').modal('hide');
                    $('#dtShipments').DataTable().ajax.reload();
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
                    if (data == 0){
                        $('#editShipment').modal('hide');
                        $('#alertDanger').append('<div id="messageAlertDanger"></div>');
                        $('#messageAlertDanger').addClass('alert alert-danger alert-dismissible fade show');
                        $('#messageAlertDanger').text('¡That name has another shipment');
                        $('#messageAlertDanger').append('<button type="button" id="dimissibleAlertDanger" data-dismiss="alert" aria-label="Close"></button>');
                        $('#dimissibleAlertDanger').addClass('close');
                        $('#dimissibleAlertDanger').append('<span aria-hidden="true">&times;</span>');
                    }else{
                        $('#editShipment').modal('hide');
                        $('#dtShipments').DataTable().ajax.reload();
                        $('#alertSuccess').append('<div id="messageAlertSuccess"></div>');
                        $('#messageAlertSuccess').text('¡The shipment has been successfully edited!');
                        $('#messageAlertSuccess').addClass('alert alert-success alert-dismissible fade show');
                        $('#messageAlertSuccess').append('<button type="button" id="dimissibleAlertSuccess" data-dismiss="alert" aria-label="Close"></button>');
                        $('#dimissibleAlertSuccess').addClass('close');
                        $('#dimissibleAlertSuccess').append('<span aria-hidden="true">&times;</span>');
                    }
                }
            });
        }
    </script>
@stop
