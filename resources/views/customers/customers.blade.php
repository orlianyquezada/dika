@extends('adminlte::page')

@section('title', 'Customers')

@section('content_header')
    <!-- Container's info -->
    <div class="container mt-3 col-lg-9">
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
                        <!-- customer registration button -->
                        <button type="button" class="btn btn-warning shadow-sm w-100" data-toggle="modal" data-target="#insertCustomer">
                            <strong>Registration</strong>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop

@section('content')
    <div class="container col-lg-9">
        <!-- Customer's table -->
        <div class="card shadow border-white">
           <div class="card-body">
                <table class="table table-hover dt-responsive nowrap" id="dtCustomers" class="display">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Customer</th>
                            <th>Phone</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Modal's insert -->
        <div class="modal fade" id="insertCustomer" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="insertCustomerLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="insertCustomerLabel"><strong>Customer Registration</strong></h5>
                    </div>
                    <div class="modal-body">
                        <form action="{{ route('customer-register') }}" method="post" autocomplete="off" id="customerRegister">
                            @csrf
                            <div class="row">
                                <div class="col-12 col-lg-7">
                                    <div class="form-group">
                                        <label for="name">Name</label>
                                        <input type="text" name="name_cu" id="name" class="form-control shadow-sm" placeholder="Name">
                                        <div class="invalid-feedback">{{ $errors->formulario->first('name_cu') }}</div>
                                    </div>
                                </div>
                                <div class="col-12 col-lg-5">
                                    <div class="form-group">
                                        <label for="phone">Phone number</label>
                                        <input type="tel" name="phone_cu" id="phone" class="form-control shadow-sm" placeholder="Phone number">
                                        <div class="invalid-feedback">{{ $errors->formulario->first('phone_cu') }}</div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" form="customerRegister" class="btn btn-warning">Save</button>
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
                        <form id="updateCustomer" autocomplete="off">
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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.2/css/bootstrap.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.3.0/css/responsive.bootstrap4.min.css">
@stop

@section('js')
    <script src="https://cdn.datatables.net/responsive/2.3.0/js/dataTables.responsive.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.3.0/js/responsive.bootstrap4.min.js"></script>
    <script>
        $(document).ready( function () {            
            $('#dtCustomers').DataTable({
                responsive: true,
                autoWidth: false,
                ajax:{
                    url: 'allCustomers',
                    method: "GET",
                },
                columns:[
                    {data: 'id'},
                    {data: 'name_cu'},
                    {data: 'phone_cu'},
                    {data: 'id',
                    render: function(data,t,w,meta){
                        return '<div class="btn-group btn-group-sm justify-content-end" role="group" aria-label=""><button onclick="editCustomer('+data+');" class="btn btn-xs btn-ligth text-dark" title="Edit"><i class="fa fa-fw fa-pen"></i></button><button class="btn btn-xs btn-ligth text-dark" title="Delete" onclick="deleteCustomer('+data+')"><i class="fa fa-fw fa-trash"></i></button></div>';
                    }}
                ]
            });
        } );

        function editCustomer(idCustomer){
            $.ajax({
                type: "GET",
                url: 'viewCustomer/'+idCustomer,
                success: function(data){
                    $('#nameEdit').val(data.name_cu);
                    $('#phoneEdit').val(data.phone_cu);
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
            $('#editCustomer').modal('show');
        }

        function updateCustomer(){
            $.ajax({
                headers: {'X-CSRF-TOKEN': $('input[name=_token]').val()},
                type: "POST",
                url: +$('#idCustomerEdit').val(),
                data: $('form#updateCustomer').serialize(),
                error: function(data){
                    $('#editCustomer').modal('hide');
                    $('#dtCustomers').DataTable().ajax.reload();
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
                    $('#editCustomer').modal('hide');
                    $('#dtCustomers').DataTable().ajax.reload();
                    $('#alertSuccess').append('<div id="messageAlertSuccess"></div>');
                    $('#messageAlertSuccess').text('¡The customer has been successfully edited!');
                    $('#messageAlertSuccess').addClass('alert alert-success alert-dismissible fade show');
                    $('#messageAlertSuccess').append('<button type="button" id="dimissibleAlertSuccess" data-dismiss="alert" aria-label="Close"></button>');
                    $('#dimissibleAlertSuccess').addClass('close');
                    $('#dimissibleAlertSuccess').append('<span aria-hidden="true">&times;</span>');
                }
            });
        }

        function deleteCustomer(idCustomer){
            $('#idCustomerDelete').val(idCustomer);
            $('#deleteCustomer').modal('show');
        }

        function confirmDelete(){
            $.ajax({
                type: "GET",
                url: 'deleteCustomer/'+$('#idCustomerDelete').val(),
                error: function(data){
                    $('#deleteCustomer').modal('hide');
                    $('#dtCustomers').DataTable().ajax.reload();
                    $('#alertDanger').append('<div id="messageAlertDanger"></div>');
                    $('#messageAlertDanger').addClass('alert alert-danger alert-dismissible fade show');
                    $('#messageAlertDanger').text('¡Information not available!');
                    $('#messageAlertDanger').append('<button type="button" id="dimissibleAlertDanger" data-dismiss="alert" aria-label="Close"></button>');
                    $('#dimissibleAlertDanger').addClass('close');
                    $('#dimissibleAlertDanger').append('<span aria-hidden="true">&times;</span>');
                },
                success: function(data){
                    if (data == 1){
                        $('#deleteCustomer').modal('hide');
                        $('#dtCustomers').DataTable().ajax.reload();
                        $('#alertDanger').append('<div id="messageAlertDanger"></div>');
                        $('#messageAlertDanger').addClass('alert alert-danger alert-dismissible fade show');
                        $('#messageAlertDanger').text('¡The customer cannot be deleted because it has open movements!');
                        $('#messageAlertDanger').append('<button type="button" id="dimissibleAlertDanger" data-dismiss="alert" aria-label="Close"></button>');
                        $('#dimissibleAlertDanger').addClass('close');
                        $('#dimissibleAlertDanger').append('<span aria-hidden="true">&times;</span>');
                    }else{
                        $('#deleteCustomer').modal('hide');
                        $('#dtCustomers').DataTable().ajax.reload();
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
