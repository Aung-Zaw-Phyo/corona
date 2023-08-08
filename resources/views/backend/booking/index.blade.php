@extends('backend.layouts.app')
@section('title', 'Admin User')
@section('content')
    <form action="{{ route('booking.index') }}">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h3 class="col-4 col-md-6 m-0 p-0">Booking List</h3>
            <div class="input-group col-8 col-md-6 col-lg-4 m-0 p-0 search d-flex align-items-center">
                <input type="text" value="{{ $_GET && $_GET['search'] ? $_GET['search'] : '' }}" name="search" class="form-control" placeholder="Search orders" aria-label="Search orders" aria-describedby="button-addon2">
                <button type="submit" class="btn-theme m-0" type="button" id="button-addon2">Search</button>
            </div>
        </div>
    </form>
    <div class="row">
        @foreach ($bookings as $booking)
            <div class="col-md-6 col-lg-4 p-2">
                <div class="card h-100 booking-card">
                    <div class="card-body p-3">
                        <div class="mb-3">
                            <p class=" mb-1"><i class="fa-solid fa-user me-2"></i> Name</p>
                            <p class="mb-1">{{ $booking->name }}</p>
                        </div>
                        <div class="mb-3">
                            <p class=" mb-1"><i class="fa-solid fa-phone me-2"></i> Phone</p>
                            <p class="mb-1">{{ $booking->phone }}</p>
                        </div>
                        <div class="mb-3">
                            <p class=" mb-1"><i class="fa-solid fa-envelope me-2"></i> Email</p>
                            <p class="mb-1">{{ $booking->email ? $booking->email : '...' }}</p>
                        </div>
                        <div class="mb-3">
                            <p class=" mb-1"><i class="fa-solid fa-users me-2"></i> Person</p>
                            <p class="mb-1"><span class="badge badge-primary">{{ $booking->person }}</span></p>
                        </div>
                        <div class="mb-3">
                            <p class=" mb-1"><i class="fa-solid fa-calendar-days me-2"></i> Date</p>
                            <p class="mb-1"><span class="badge badge-primary">{{ $booking->date }}</span></p>
                        </div>
                        <div class="mb-3">
                            <p class=" mb-1"><i class="fa-solid fa-clock me-2"></i> Time</p>
                            <p class="mb-1"><span class="badge badge-primary">{{ $booking->time }}</span></p>
                        </div>
                        <div class="mb-3">
                            <p class=" mb-1"><i class="fa-solid fa-message me-2"></i> Message</p>
                            <p class="mb-1">{{ $booking->message ? $booking->message : '...' }}</p>
                        </div>
                    </div>
                </div>    
            </div>   
        @endforeach 
    </div> 
    <div class="py-3 d-flex justify-content-center">
        {{ $bookings->links() }}
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


          