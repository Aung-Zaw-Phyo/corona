@extends('backend.layouts.app')
@section('title', 'Admin User')
@section('content')
    <form action="{{ route('order.index') }}">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h3 class="col-4 col-md-6 m-0 p-0">Orders</h3>
            <div class="input-group col-8 col-md-6 col-lg-4 m-0 p-0 search d-flex align-items-center">
                <input type="text" value="{{ $_GET && $_GET['search'] ? $_GET['search'] : '' }}" name="search" class="form-control" placeholder="Search orders" aria-label="Search orders" aria-describedby="button-addon2">
                <button type="submit" class="btn-theme m-0" type="button" id="button-addon2">Search</button>
            </div>
        </div>
    </form>
    <div class="row">
        @foreach ($orders as $order)
            <div class="col-md-6 col-lg-4 p-2">
                <div class="card h-100 relative order-card">
                    <div class="card-body p-3">
                        <div class="order-status">
                            @if ($order->status == 'paid')
                                <form action="{{ route('order.complete', $order->id) }}" method="POST">
                                    @csrf
                                    <button class="status-icon paid"><i class="fa-solid fa-truck paid"></i></button>
                                </form>
                            @endif
                            @if ($order->status == 'completed')
                                <span class="status-icon completed"><i class="fa-solid fa-check"></i></span>
                            @endif
                        </div>
                        <div class="mb-3">
                            <p class=" mb-1">Order Number</p>
                            <p class="mb-1">{{ $order->order_no }}</p>
                        </div>
                        <div class="mb-3">
                            <p class=" mb-1">Order Status</p>
                            <p class="mb-1"><span class="badge p-1 text-uppercase badge-primary">{{ $order->status }}</span></p>
                        </div>
                        <div class="mb-3">
                            <p class=" mb-1">Name</p>
                            <p class="mb-1">{{ $order->name }}</p>
                        </div>
                        <div class="mb-3">
                            <p class=" mb-1">Phone</p>
                            <p class="mb-1">{{ $order->phone }}</p>
                        </div>
                        <div class="mb-3">
                            <p class=" mb-1">Address</p>
                            <p class="mb-1">{{ $order->address }}</p>
                        </div>
                        <div class="mb-3">
                            <p class=" mb-1">Message</p>
                            <p class="mb-1">{{ $order->message ? $order->message : '...' }}</p>
                        </div>
                        <div class="mb-3">
                            <p class=" mb-1">Date_Time</p>
                            <p class="mb-1">{{ $order->created_at->diffForHumans() }}</p>
                        </div>
                    </div>
                </div>    
            </div>   
        @endforeach 
    </div> 
    <div class="py-3 d-flex justify-content-center">
        {{ $orders->links() }}
    </div>
@endsection

@section('script')
    <script>
        $(document).ready(function () {
            let data_table = $('#admin_user_table').DataTable({
                responsive: true,
                processing: true,
                serverSide: true,
                ajax: 'admin-user/data-table/ssd',
                columns: [
                    {data: 'plus-icon', name: 'plus-icon', class: 'text-center'},
                    {data: 'name', name: 'name', class: 'text-center py-3'},
                    {data: 'email', name: 'email', class: 'text-center py-3'},
                    {data: 'phone', name: 'phone', class: 'text-center py-3'},
                    {data: 'updated_at', name: 'updated_at', class: 'text-center py-3'},
                    {data: 'action', name: 'action', class: 'text-center py-3', orderable: false, searchable: false},
                ],
                columnDefs: [
                    {
                        targets: [0],
                        class: 'control'
                    },
                    {
                        targets: "no-sort",
                        sortable: false
                    },
                    {
                        targets: "no-search",
                        searchable: false
                    },
                    {
                        targets: "hidden",
                        visible: false
                    },
                    
                ],
                order: [[4, 'desc']],
                language: {
                    paginate: {
                        next: "<i class='fa-solid fa-circle-arrow-right'></i>",
                        previous: "<i class='fa-solid fa-circle-arrow-left'></i>"
                    },
                }
            });

            $(document).on('click', '.delete-btn', function (e) { //This is parent to child selector to know latest render data in datatable.
                e.preventDefault()
                let id = $(this).data('id');
                swal({
                    text: "Are you sure you want to delete?",
                    buttons: true,
                    dangerMode: true,
                })
                .then((willDelete) => {
                    if (willDelete) {
                        $.ajax({
                            url: `/admin/admin-user/${id}`,
                            method: "DELETE"
                        }).done(function(res) {
                            if(res == 'success') {
                                data_table.ajax.reload()
                            }else {
                                console.log('fail')
                            }
                        });
                    } 
                });
            })
        })
    </script>
@endsection


          