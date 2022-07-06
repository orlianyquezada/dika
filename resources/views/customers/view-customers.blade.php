@extends('adminlte::page')

@section('title', 'Customers')

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
                        <h3><strong>Customers</strong></h3>
                    </div>
                    <div class="col-12 col-lg-3">
                        <!-- customer register button -->
                        <button type="button" class="btn btn-warning shadow-sm w-100" data-toggle="modal" data-target="#insertCustomer">
                            <strong>Register</strong>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop

@section('content')
    <div class="container">
        <!-- Customer's table -->
        <div class="card shadow border-white">
           <div class="card-body">
                <table class="table table-hover dt-responsive nowrap display dataTable_width_auto" id="dtCustomers" style="width:100%">
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
        <div class="modal fade" id="insertCustomer" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="insertCustomerLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header bg-warning">
                        <h5 class="modal-title" id="insertCustomerLabel"><strong>Customer Register</strong></h5>
                    </div>
                    <div class="modal-body">
                        <form id="customerRegister" autocomplete="off">
                            <input type="hidden" name="_token" id="token" value="{{ csrf_token() }}">
                            <div class="row">
                                <div class="col-12 col-lg-5">
                                    <div class="form-group">
                                        <label for="nameInsert">Name</label>
                                        <input type="text" name="name_cu" id="nameInsert" class="form-control shadow-sm" placeholder="Name">
                                    </div>
                                </div>
                                <div class="col-12 col-lg-3">
                                    <div class="form-group">
                                        <label for="phoneInsert">Phone number</label>
                                        <input type="tel" name="phone_cu" id="phoneInsert" class="form-control shadow-sm" placeholder="Phone number">
                                    </div>
                                </div>
                                <div class="col-12 col-lg-4">
                                    <div class="form-group">
                                        <label for="emailInsert">Email</label>
                                        <input type="email" name="email_cu" id="emailInsert" class="form-control shadow-sm" placeholder="Email">
                                    </div>
                                </div>
                            </div>
                        </form>
                        <div id="alertDangerRegister"></div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" form="customerRegister" class="btn btn-warning" onclick="registerCustomer(event);">Save</button>
                        <button type="button" class="btn btn-outline-secondary" data-dismiss="modal" onclick="cleanModal();">Close</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal's update -->
        <div class="modal fade" id="editCustomer" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="editCustomerLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header bg-warning">
                        <h5 class="modal-title" id="editCustomerLabel"><strong>Edit Customer</strong></h5>
                    </div>
                    <div class="modal-body">
                        <form id="updateCustomer" autocomplete="off">
                            <input type="hidden" name="id" id="idCustomerEdit">
                            <input type="hidden" name="_token" id="token" value="{{ csrf_token() }}">
                            <div class="row">
                                <div class="col-12 col-lg-5">
                                    <div class="form-group">
                                        <label for="phoneEdit">Name</label>
                                        <input type="text" id="nameEdit" name="name_cu" class="form-control shadow-sm">
                                    </div>
                                </div>
                                <div class="col-12 col-lg-3">
                                    <div class="form-group">
                                        <label for="phoneEdit">Phone</label>
                                        <input type="tel" id="phoneEdit" name="phone_cu" class="form-control shadow-sm">
                                    </div>
                                </div>
                                <div class="col-12 col-lg-4">
                                    <div class="form-group">
                                        <label for="emailEdit">Email</label>
                                        <input type="email" name="email_cu" id="emailEdit" class="form-control shadow-sm" placeholder="Email">
                                    </div>
                                </div>
                            </div>
                        </form>
                        <div id="alertDangerUpdate"></div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" id="btnEdit" form="updateCustomer" class="btn btn-warning shadow-sm" onclick="updateCustomer(event);">Edit</button>
                        <button type="button" class="btn btn-outline-secondary" data-dismiss="modal" onclick="cleanModal();">Close</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal's delete -->
        <div class="modal fade" id="deleteCustomer" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="deleteCustomerLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header bg-warning">
                        <h5 class="modal-title" id="deleteCustomerLabel"><strong>Delete Customer</strong></h5>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" id="idCustomerDelete">
                        <p class="lead">Do you want to delete the customer?</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-warning" onclick="confirmDelete();">Delete</button>
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
            $('#dtCustomers').DataTable({
                responsive: true,
                autoWidth: false,
                ajax:{
                    url: 'all-customers',
                    method: "GET",
                },
                columns:[
                    {data: 'name_cu'},
                    {data: 'phone_cu'},
                    {data: 'email_cu'},
                    {width: "12%", orderable:false, data: 'id',
                    render: function(data,t,w,meta){
                        return '<div class="btn-group btn-group-sm justify-content-end" role="group" aria-label=""><button onclick="editCustomer('+data+');" class="btn btn-xs btn-ligth text-dark" title="Edit"><i class="fa fa-fw fa-pen"></i></button><button class="btn btn-xs btn-ligth text-dark" title="Delete" onclick="deleteCustomer('+data+')"><i class="fa fa-fw fa-trash"></i></button><a href="view-sub-customers/'+data+'" class="btn btn-xs btn-ligth text-dark" title="Sub Customers"><i class="fa fw fa-users"></i></a></div>';
                    }}
                ]
            });
        } );

        function registerCustomer(event){
            event.preventDefault();
            $.ajax({
                headers: {'X-CSRF-TOKEN': $('input[name=_token]').val()},
                type: "POST",
                url: 'register-customer',
                data: $('form#customerRegister').serialize(),
                success: function(data){
                    if (data == 0){
                        $('#alertDangerRegister').empty();
                        $('#alertDangerRegister').html('<div class="alert alert-danger alert-dismissible fade show" role="alert">¡That name, number and email has another customer!<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
                    }else{
                        $('#insertCustomer').modal('hide');
                        $('#dtCustomers').DataTable().ajax.reload();
                        $('#alertSuccess').empty();
                        $('#alertSuccess').html('<div class="alert alert-success alert-dismissible fade show" role="alert">¡The customer has been successfully saved!<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
                    }
                    $('#nameInsert').val('');
                    $('#phoneInsert').val('');
                    $('#emailInsert').val('');
                },
                error: function(data){
                    $('#alertDangerRegister').empty();
                    $('#alertDangerRegister').html('<div class="alert alert-danger alert-dismissible fade show" role="alert"><ul id="listAlert"></ul><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
                    var resultado = data.responseJSON.errors;
                    var contenido = '';
                    $.each(resultado, function(index, value) {
                        contenido += '<li>'+value+'</li>';
                    });
                    $("#listAlert").html(contenido);
                }
            });
        }

        function editCustomer(idCustomer){
            $.ajax({
                type: "GET",
                url: 'consult-customer/'+idCustomer,
                success: function(data){
                    $('#nameEdit').val(data.name_cu);
                    $('#phoneEdit').val(data.phone_cu);
                    $('#emailEdit').val(data.email_cu);
                    $('#idCustomerEdit').val(data.id);
                },
                error: function(data){
                    $('#alertDangerUpdate').empty();
                    $('#alertDangerUpdate').html('<div class="alert alert-danger alert-dismissible fade show" role="alert">¡Information not available!<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
                }
            });
            $('#editCustomer').modal('show');
        }

        function updateCustomer(event){
            event.preventDefault
            $.ajax({
                headers: {'X-CSRF-TOKEN': $('input[name=_token]').val()},
                type: "POST",
                url: +$('#idCustomerEdit').val(),
                data: $('form#updateCustomer').serialize(),
                error: function(data){
                    $('#alertDangerUpdate').empty();
                    $('#alertDangerUpdate').html('<div class="alert alert-danger alert-dismissible fade show" role="alert"><ul id="listAlert"></ul><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
                    var resultado = data.responseJSON.errors;
                    var contenido = '';
                    $.each(resultado, function(index, value) {
                        contenido += '<li>'+value+'</li>';
                    });
                    $("#listAlert").html(contenido);
                },
                success: function(data){
                    if (data == 0){
                        $('#alertDangerUpdate').empty();
                        $('#alertDangerUpdate').html('<div class="alert alert-danger alert-dismissible fade show" role="alert">¡That name, number and email has another customer!<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
                    }else{
                        $('#editCustomer').modal('hide');
                        $('#dtCustomers').DataTable().ajax.reload();
                        $('#alertSuccess').empty();
                        $('#alertSuccess').html('<div class="alert alert-success alert-dismissible fade show" role="alert">¡The customer has been successfully edited!<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
                    }
                }
            });
        }

        function cleanModal(){
            $('#nameInsert').val('');
            $('#phoneInsert').val('');
            $('#emailInsert').val('');
            $('#alertDangerRegister').empty();
            $('#alertDangerUpdate').empty();
        }

        function deleteCustomer(idCustomer){
            $('#idCustomerDelete').val(idCustomer);
            $('#deleteCustomer').modal('show');
        }

        function confirmDelete(){
            $.ajax({
                type: "GET",
                url: 'delete-customer/'+$('#idCustomerDelete').val(),
                error: function(data){
                    $('#deleteCustomer').modal('hide');
                    $('#alertDanger').empty();
                    $('#alertDanger').html('<div class="alert alert-danger alert-dismissible fade show" role="alert">¡Information not available!<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
                },
                success: function(data){
                    if (data == 1){
                        $('#alertDanger').empty();
                        $('#alertDanger').html('<div class="alert alert-danger alert-dismissible fade show" role="alert">¡The customer cannot be deleted because it has open items!<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
                    }else{
                        $('#deleteCustomer').modal('hide');
                        $('#dtCustomers').DataTable().ajax.reload();
                        $('#alertSuccess').empty();
                        $('#alertSuccess').html('<div class="alert alert-success alert-dismissible fade show" role="alert">¡The customer has been successfully deleted!<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
                    }
                }
            });
        }
    </script>
@stop
