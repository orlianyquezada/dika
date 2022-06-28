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
                <div class="row">
                    <div class="col-12 col-lg-2">
                        <div class="form-group">
                            <label for="idCustomerPrimary">ID</label>
                            <input type="text" id="idCustomerPrimary" class="form-control shadow-sm" value="{{ $customer->id }}" disabled>
                        </div>
                    </div>
                    <div class="col-12 col-lg-4">
                        <div class="form-group">
                            <label for="nameCustomerPrimary">Name</label>
                            <input type="text" id="nameCustomerPrimary" class="form-control shadow-sm" value="{{ $customer->name_cu }}" disabled>
                        </div>
                    </div>
                    <div class="col-12 col-lg-2">
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
                <!-- sub customer registration button -->
                <button type="button" class="btn btn-warning shadow-sm" data-toggle="modal" data-target="#insertSubCustomer">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-person-fill pb-1" viewBox="0 0 16 16">
                        <path d="M3 14s-1 0-1-1 1-4 6-4 6 3 6 4-1 1-1 1H3zm5-6a3 3 0 1 0 0-6 3 3 0 0 0 0 6z"/>
                    </svg>
                    Sub Customer Registration
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
                <table class="table table-hover dt-responsive nowrap display" id="dtSubCustomers">
                    <thead>
                        <tr>
                            <th>ID</th>
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
                    <div class="modal-header">
                        <h5 class="modal-title" id="insertSubCustomerLabel"><strong>Sub Customer Registration</strong></h5>
                    </div>
                    <div class="modal-body">
                        <form action="{{ route('customer-register') }}" method="post" autocomplete="off" id="subCustomerRegister">
                            @csrf
                            <input type="hidden" name="customer_id" value="{{ $customer->id }}">
                            <div class="form-group">
                                <label for="name">Name</label>
                                <input type="text" name="name_cu" id="name" class="form-control shadow-sm" placeholder="Name">
                            </div>
                            <div class="form-group">
                                <label for="phone">Phone number</label>
                                <input type="tel" name="phone_cu" id="phone" class="form-control shadow-sm" placeholder="Phone number">
                            </div>
                            <div class="form-group">
                                <label for="email">Email</label>
                                <input type="email" name="email_cu" id="email" class="form-control shadow-sm" placeholder="Email">
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" form="subCustomerRegister" class="btn btn-warning">Save</button>
                        <button type="button" class="btn btn-outline-secondary" data-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal's update -->
        <div class="modal fade" id="editSubCustomer" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="editSubCustomerLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="editSubCustomerLabel"><strong>Edit Sub Customer</strong></h5>
                    </div>
                    <div class="modal-body">
                        <form id="updateCustomer" autocomplete="off">
                            <input type="hidden" name="_token" id="token" value="{{ csrf_token() }}">
                            <input type="hidden" name="id" id="idCustomerEdit">
                            <input type="hidden" name="customer_id" value="{{ $customer->id }}">
                            <div class="form-group">
                                <label for="phoneEdit">Name</label>
                                <input type="text" id="nameEdit" name="name_cu" class="form-control shadow-sm">
                            </div>
                            <div class="form-group">
                                <label for="phoneEdit">Phone</label>
                                <input type="tel" id="phoneEdit" name="phone_cu" class="form-control shadow-sm">
                            </div>
                            <div class="form-group">
                                <label for="emailEdit">Email</label>
                                <input type="email" name="email_cu" id="emailEdit" class="form-control shadow-sm">
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
        <div class="modal fade" id="deleteSubCustomer" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="deleteSubCustomerLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="deleteSubCustomerLabel"><strong>Delete Sub Customer</strong></h5>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" id="idSubCustomerDelete">
                        <p class="lead">Do you want to delete the sub customer?</p>
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
                    {data: 'id'},
                    {data: 'name_cu'},
                    {data: 'phone_cu'},
                    {data: 'email_cu'},
                    {data: 'id',
                    render: function(data,t,w,meta){
                        return '<div class="btn-group btn-group-sm justify-content-end" role="group" aria-label=""><button onclick="editSubCustomer('+data+');" class="btn btn-xs btn-ligth text-dark" title="Edit"><i class="fa fa-fw fa-pen"></i></button><button class="btn btn-xs btn-ligth text-dark" title="Delete" onclick="deleteSubCustomer('+data+')"><i class="fa fa-fw fa-trash"></i></button></div>';
                    }}
                ]
            });
        } );

        function editSubCustomer(idCustomer){
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
                    $('#editCustomer').modal('hide');
                    $('#alertDanger').append('<div id="messageAlertDanger"></div>');
                    $('#messageAlertDanger').addClass('alert alert-danger alert-dismissible fade show');
                    $('#messageAlertDanger').text('¡Information not available!');
                    $('#messageAlertDanger').append('<button type="button" id="dimissibleAlertDanger" data-dismiss="alert" aria-label="Close"></button>');
                    $('#dimissibleAlertDanger').addClass('close');
                    $('#dimissibleAlertDanger').append('<span aria-hidden="true">&times;</span>');
                }
            });
            $('#editSubCustomer').modal('show');
        }

        function updateCustomer(){
            $.ajax({
                headers: {'X-CSRF-TOKEN': $('input[name=_token]').val()},
                type: "POST",
                url: +$('#idCustomerEdit').val(),
                data: $('form#updateCustomer').serialize(),
                error: function(data){
                    console.log(data.responseJSON.errors);
                    $('#editSubCustomer').modal('hide');
                    $('#dtSubCustomers').DataTable().ajax.reload();
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
                        $('#editSubCustomer').modal('hide');
                        $('#alertDanger').append('<div id="messageAlertDanger"></div>');
                        $('#messageAlertDanger').addClass('alert alert-danger alert-dismissible fade show');
                        $('#messageAlertDanger').text('¡That name, number and email has another sub customer');
                        $('#messageAlertDanger').append('<button type="button" id="dimissibleAlertDanger" data-dismiss="alert" aria-label="Close"></button>');
                        $('#dimissibleAlertDanger').addClass('close');
                        $('#dimissibleAlertDanger').append('<span aria-hidden="true">&times;</span>');
                    }else{
                        $('#editSubCustomer').modal('hide');
                        $('#dtSubCustomers').DataTable().ajax.reload();
                        $('#alertSuccess').append('<div id="messageAlertSuccess"></div>');
                        $('#messageAlertSuccess').text('¡The sub customer has been successfully edited!');
                        $('#messageAlertSuccess').addClass('alert alert-success alert-dismissible fade show');
                        $('#messageAlertSuccess').append('<button type="button" id="dimissibleAlertSuccess" data-dismiss="alert" aria-label="Close"></button>');
                        $('#dimissibleAlertSuccess').addClass('close');
                        $('#dimissibleAlertSuccess').append('<span aria-hidden="true">&times;</span>');
                    }
                }
            });
        }

        function deleteSubCustomer(idCustomer){
            $('#idSubCustomerDelete').val(idCustomer);
            $('#deleteSubCustomer').modal('show');
        }

        function confirmDelete(){
            $.ajax({
                type: "GET",
                url: 'delete-customer/'+$('#idSubCustomerDelete').val(),
                error: function(data){
                    $('#deleteSubCustomer').modal('hide');
                    $('#dtSubCustomers').DataTable().ajax.reload();
                    $('#alertDanger').append('<div id="messageAlertDanger"></div>');
                    $('#messageAlertDanger').addClass('alert alert-danger alert-dismissible fade show');
                    $('#messageAlertDanger').text('¡Information not available!');
                    $('#messageAlertDanger').append('<button type="button" id="dimissibleAlertDanger" data-dismiss="alert" aria-label="Close"></button>');
                    $('#dimissibleAlertDanger').addClass('close');
                    $('#dimissibleAlertDanger').append('<span aria-hidden="true">&times;</span>');
                },
                success: function(data){
                    if (data == 1){
                        $('#deleteSubCustomer').modal('hide');
                        $('#dtSubCustomers').DataTable().ajax.reload();
                        $('#alertDanger').append('<div id="messageAlertDanger"></div>');
                        $('#messageAlertDanger').addClass('alert alert-danger alert-dismissible fade show');
                        $('#messageAlertDanger').text('¡The customer cannot be deleted because it has open movements!');
                        $('#messageAlertDanger').append('<button type="button" id="dimissibleAlertDanger" data-dismiss="alert" aria-label="Close"></button>');
                        $('#dimissibleAlertDanger').addClass('close');
                        $('#dimissibleAlertDanger').append('<span aria-hidden="true">&times;</span>');
                    }else{
                        $('#deleteSubCustomer').modal('hide');
                        $('#dtSubCustomers').DataTable().ajax.reload();
                        $('#alertSuccess').append('<div id="messageAlertDanger"></div>');
                        $('#messageAlertDanger').text('¡The customer has been successfully deleted!');
                        $('#messageAlertDanger').addClass('alert alert-success alert-dismissible fade show');
                        $('#messageAlertDanger').append('<button type="button" id="dimissibleAlertDanger" data-dismiss="alert" aria-label="Close"></button>');
                        $('#dimissibleAlertDanger').addClass('close');
                        $('#dimissibleAlertDanger').append('<span aria-hidden="true">&times;</span>');
                    }
                }
            });
        }
    </script>
@stop