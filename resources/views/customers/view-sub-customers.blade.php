@extends('adminlte::page')

@section('title', 'Customers')

@section('content_header')
    <!-- Container's info -->
    <div class="container mt-3">
        <nav aria-label="breadcrumb" class="mb-3">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('customers') }}">Customers</a></li>
                <li class="breadcrumb-item active" aria-current="page">Sub Customer {{ $customer->name_cu }}</li>
            </ol>
        </nav>
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
            <div class="card-header bg-secondary">
                Information of {{ $customer->name_cu }}
            </div>
            <div class="card-body">
                <input type="hidden" value="{{ $customer->id }}" id="idCustomerPrimary">
                <div class="row">
                    <div class="col-12 col-lg-5">
                        <div class="form-group">
                            <label for="nameCustomerPrimary">Name</label>
                            <input type="text" id="nameCustomerPrimary" class="form-control shadow-sm" value="{{ $customer->name_cu }}" disabled>
                        </div>
                    </div>
                    <div class="col-12 col-lg-3">
                        <div class="form-group">
                            <label for="phoneCustomerPrimary">Phone</label>
                            <input type="text" id="phoneCustomerPrimary" class="form-control shadow-sm" value="{{ $customer->phone_cu }}" disabled>
                        </div>
                    </div>
                    <div class="col-12 col-lg-4">
                        <div class="form-group">
                            <label for="emailCustomerPrimary">Phone</label>
                            <input type="text" id="emailCustomerPrimary" class="form-control shadow-sm" value="{{ $customer->email_cu }}" disabled>
                        </div>
                    </div>
                </div>
                <hr class="display-4">
                <!-- sub customer register button -->
                <button type="button" class="btn btn-warning shadow-sm" data-toggle="modal" data-target="#insertSubCustomer">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-person-fill pb-1" viewBox="0 0 16 16">
                        <path d="M3 14s-1 0-1-1 1-4 6-4 6 3 6 4-1 1-1 1H3zm5-6a3 3 0 1 0 0-6 3 3 0 0 0 0 6z"/>
                    </svg>
                    Sub Customer Register
                </button>
            </div>
        </div>
    </div>
@stop

@section('content')
    <div class="container">
        <!-- Customer's table -->
        <div class="card shadow border-white">
           <div class="card-body">
                <table class="table table-hover dt-responsive nowrap display dataTable_width_auto" id="dtSubCustomers" style="width:100%">
                    <thead>
                        <tr>
                            <th>Customer</th>
                            <th>Phone</th>
                            <th>Email</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody></tbody>
                </table>
            </div>
        </div>

        <!-- Modal's insert -->
        <div class="modal fade" id="insertSubCustomer" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="insertSubCustomerLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header bg-warning">
                        <h5 class="modal-title" id="insertSubCustomerLabel"><strong>Sub Customer Register</strong></h5>
                    </div>
                    <div class="modal-body" id="bodyRegister">
                        <form id="subCustomerRegister" autocomplete="off">
                            <input type="hidden" name="_token" id="token" value="{{ csrf_token() }}">
                            <input type="hidden" name="customer_id" value="{{ $customer->id }}">
                            <div class="form-group">
                                <label for="subCustomerInsert">Customers</label>
                                <select name="sub_customer_id" id="subCustomerInsert" class="form-control shadow-sm">
                                    <option value="">select an option</option>
                                </select>
                            </div>
                        </form>
                        <div id="alertDangerRegister"></div>
                        <div id="alertSuccessInsert"></div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" id="insertButton" form="subCustomerRegister" class="btn btn-warning" onclick="insertSubCustomer(event);">Save</button>
                        <button type="button" class="btn btn-outline-secondary" data-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal's delete -->
        <div class="modal fade" id="deleteSubCustomer" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="deleteSubCustomerLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header bg-warning">
                        <h5 class="modal-title" id="deleteSubCustomerLabel"><strong>Delete Sub Customer</strong></h5>
                    </div>
                    <div class="modal-body">
                        <form id="subCustomerDelete">
                            <input type="hidden" name="_token" id="token" value="{{ csrf_token() }}">
                            <input type="hidden" value="{{ $customer->id }}" name="customer_id" id="idCustomerDelete">
                            <input type="hidden" name="sub_customer_id" id="idSubCustomerDelete">
                        </form>
                        <p class="lead">Do you want to delete the sub customer?</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" form="subCustomerDelete" class="btn btn-warning" onclick="confirmDelete();">Delete</button>
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
            $('#dtSubCustomers').DataTable({
                responsive: true,
                autoWidth: false,
                ajax:{
                    url: 'all-sub-customers/'+$('#idCustomerPrimary').val(),
                    method: "GET",
                },
                columns:[
                    {data: 'name_cu'},
                    {data: 'phone_cu'},
                    {data: 'email_cu'},
                    {width: "5%", orderable:false, data: 'id',
                    render: function(data,t,w,meta){
                        if (data != $('#idCustomerPrimary').val()){
                            return '<div class="btn-group btn-group-sm justify-content-end" role="group" aria-label=""><button class="btn btn-xs btn-ligth text-dark" title="Delete" onclick="deleteSubCustomer('+data+')"><i class="fa fa-fw fa-trash"></i></button></div>';
                        }
                        return '<div hidden>'+data+'</div>';
                    }}
                ]
            });
        } );

        $('#subCustomerInsert').click( function(){
            $.ajax({
                type: "GET",
                url: 'get-sub-customers/'+$('#idCustomerPrimary').val(),
                success: function(data){
                    console.log(data);
                    var tamano = data.length;
                    var contenido = '';
                    if (tamano > 0){
                        for (var i=0; i<tamano; i++) {
                            contenido += '<option value="'+data[i].id+'">'+data[i].name_cu+' - '+data[i].phone_cu+' - '+data[i].email_cu+'</option>';
                        }
                        $("#subCustomerInsert").html(contenido);
                        $('#insertButton').prop('disabled',false);
                    }else{
                        contenido += '<option value="">All customers have been added</option>';
                        $("#subCustomerInsert").html(contenido);
                        $('#alertSuccessInsert').empty();
                        $('#insertButton').prop('disabled',true);
                    }
                },
                error: function(data){
                    $('#insertSubCustomer').modal('hide');
                    $('#alertDanger').empty();
                    $('#alertDanger').html('<div class="alert alert-danger alert-dismissible fade show" role="alert">¡Information not available!<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
                }
            });
        });

        function insertSubCustomer(event){
            event.preventDefault();
            $.ajax({
                headers: {'X-CSRF-TOKEN': $('input[name=_token]').val()},
                type: "POST",
                url: 'register-sub-customer',
                data: $('form#subCustomerRegister').serialize(),
                error: function(data){
                    $('#alertSuccessInsert').empty();
                    $('#alertDangerRegister').empty();
                    $('#alertDangerRegister').html('<div class="alert alert-danger alert-dismissible fade show" role="alert"><ul id="listAlert"></ul><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
                    var resultado = data.responseJSON.errors;
                    var contenido = '';
                    $.each(resultado, function(index, value) {
                        contenido += '<li>'+value+'</li>';
                    });
                    $("#listAlert").html(contenido);
                },
                success: function(data){
                    $('#alertDangerRegister').empty();
                    $('#alertSuccessInsert').empty();
                    if (data == 0){
                        $('#alertDangerRegister').html('<div class="alert alert-danger alert-dismissible fade show" role="alert">¡You have already registered that sub customer!<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
                    }else{
                        $('#alertSuccessInsert').html('<div class="alert alert-success alert-dismissible fade show" role="alert">¡The customer has been successfully saved!<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
                        $('#dtSubCustomers').DataTable().ajax.reload();
                    }
                }
            });
        }

        function cleanAlertsInsert(){
            $('#alertDangerRegister').empty();
            $('#alertSuccessInsert').empty();
        }

        function deleteSubCustomer(idSubCustomer){
            $('#idSubCustomerDelete').val(idSubCustomer);
            $('#deleteSubCustomer').modal('show');
        }

        function confirmDelete(){
            $.ajax({
                headers: {'X-CSRF-TOKEN': $('input[name=_token]').val()},
                type: "POST",
                url: 'delete-sub-customer',
                data: $('form#subCustomerDelete').serialize(),
                error: function(data){
                    $('#deleteCustomer').modal('hide');
                    $('#alertDanger').empty();
                    $('#alertDanger').html('<div class="alert alert-danger alert-dismissible fade show" role="alert">¡Information not available!<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
                },
                success: function(data){
                    if (data == 0){
                        $('#deleteSubCustomer').modal('hide');
                        $('#alertDanger').empty();
                        $('#alertDanger').html('<div class="alert alert-danger alert-dismissible fade show" role="alert">¡Cannot delete itself as a sub customer!<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
                    }else if (data == 1){
                        $('#deleteSubCustomer').modal('hide');
                        $('#dtSubCustomers').DataTable().ajax.reload();
                        $('#alertSuccess').empty();
                        $('#alertSuccess').html('<div class="alert alert-success alert-dismissible fade show" role="alert">¡The sub customer has been successfully deleted!<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
                    }
                }
            });
        }
    </script>
@stop
