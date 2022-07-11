@extends('adminlte::page')

@section('title', 'Status')

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
                    <div class="col-12 col-lg-6">
                        <h3><strong>Status</strong></h3>
                    </div>
                    {{-- 
                    <div class="col-12 col-lg-3">
                        <!-- status register button -->
                        <button type="button" class="btn btn-warning shadow-sm w-100" data-toggle="modal" data-target="#insertStatus">
                            <strong>Register</strong>
                        </button>
                    </div>             
                    --}}

                </div>
            </div>
        </div>
    </div>
@stop

@section('content')
    <div class="container">
        <!-- Status's table -->
        <div class="card shadow border-white">
           <div class="card-body">
                <table class="table table-hover dt-responsive nowrap display dataTable_width_auto display" id="dtStatus" style="width:100%">
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
        <div class="modal fade" id="insertStatus" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="insertStatusLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header bg-warning">
                        <h5 class="modal-title" id="insertStatusLabel"><strong>Status Register</strong></h5>
                    </div>
                    <div class="modal-body">
                        <form action="{{ route('status-register') }}" method="post" autocomplete="off" id="statusRegister">
                            @csrf
                            <div class="form-group">
                                <label for="name">Name</label>
                                <input type="text" name="status_st" id="name" class="form-control shadow-sm" placeholder="Name">
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" form="statusRegister" class="btn btn-warning">Save</button>
                        <button type="button" class="btn btn-outline-secondary" data-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal's update -->
        <div class="modal fade" id="editStatus" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="editStatusLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header bg-warning">
                        <h5 class="modal-title" id="editStatusLabel"><strong>Edit Status</strong></h5>
                    </div>
                    <div class="modal-body">
                        <form id="updateStatus" autocomplete="off">
                            <input type="hidden" name="id" id="idStatusEdit">
                            <input type="hidden" name="_token" id="token" value="{{ csrf_token() }}">
                            <div class="form-group">
                                <label for="nameEdit">Name</label>
                                <input type="text" id="nameEdit" name="status_st" class="form-control shadow-sm">
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" id="btnEdit" form="updateStatus" class="btn btn-warning shadow-sm" onclick="updateStatus();">Update</button>
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
            $('#dtStatus').DataTable({
                responsive: true,
                autoWidth: false,
                ajax:{
                    url: 'all-status',
                    method: "GET",
                },
                columns:[
                    {data: 'status_st'},
                    {width: "10%", orderable: false, data: 'id',
                    render: function(data,t,w,meta){
                        return '<div class="btn-group btn-group-sm justify-content-end" role="group" aria-label=""><button onclick="editStatus('+data+');" class="btn btn-xs btn-ligth text-dark" title="Edit"><i class="fa fa-fw fa-pen"></i></button></div>';
                    }}
                ]
            });
        } );

        function editStatus(idStatus){
            $.ajax({
                type: "GET",
                url: 'consult-status/'+idStatus,
                success: function(data){
                    $('#nameEdit').val(data.status_st);
                    $('#idStatusEdit').val(data.id);
                },
                error: function(data){
                    $('#editStatus').modal('hide');
                    $('#alertDanger').html('<div class="alert alert-danger alert-dismissible fade show" role="alert">¡Information not available!<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
                }
            });
            $('#editStatus').modal('show');
        }

        function updateStatus(){
            $.ajax({
                headers: {'X-CSRF-TOKEN': $('input[name=_token]').val()},
                type: "POST",
                url: 'update-status/'+$('#idStatusEdit').val(),
                data: $('form#updateStatus').serialize(),
                error: function(data){
                    $('#editStatus').modal('hide');
                    $('#dtStatus').DataTable().ajax.reload();
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
                        $('#editStatus').modal('hide');
                        $('#alertDanger').append('<div id="messageAlertDanger"></div>');
                        $('#messageAlertDanger').addClass('alert alert-danger alert-dismissible fade show');
                        $('#messageAlertDanger').text('¡That name has another condition');
                        $('#messageAlertDanger').append('<button type="button" id="dimissibleAlertDanger" data-dismiss="alert" aria-label="Close"></button>');
                        $('#dimissibleAlertDanger').addClass('close');
                        $('#dimissibleAlertDanger').append('<span aria-hidden="true">&times;</span>');
                    }else{
                        $('#editStatus').modal('hide');
                        $('#dtStatus').DataTable().ajax.reload();
                        $('#alertSuccess').append('<div id="messageAlertSuccess"></div>');
                        $('#messageAlertSuccess').text('¡The condition has been successfully edited!');
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
