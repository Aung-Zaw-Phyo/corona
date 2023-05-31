@extends('backend.layouts.app')
@section('title', 'Discount')
@section('content')
    <div class="card">
        <div class="card-body">
            <div class="mb-5">
                <a href="{{ route('discount.create') }}" class="btn btn-theme"><i class="fa-solid fa-plus"></i> Create Discount</a>
            </div>
            
            <div>
                <div>
                    <table class="table table-bordered w-100" id="discount_table">
                        <thead>
                            <th></th>
                            <th class="py-3">Name</th>
                            <th class="py-3">Discount Percent</th>
                            <th class="py-3">Start Date</th>
                            <th class="py-3">End Date</th>
                            <th class="py-3">Updated At</th>
                            <th class="py-3">Action</th>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div> 
@endsection

@section('script')
    <script>
        $(document).ready(function () {
            let data_table = $('#discount_table').DataTable({
                responsive: true,
                processing: true,
                serverSide: true,
                ajax: '/admin/discount/data-table/ssd',
                columns: [
                    {data: 'plus-icon', name: 'plus-icon', class: 'text-center'},
                    {data: 'name', name: 'name', class: 'text-center py-3'},
                    {data: 'percent', name: 'percent', class: 'text-center py-3'},
                    {data: 'start_date', name: 'start_date', class: 'text-center py-3'},
                    {data: 'end_date', name: 'end_date', class: 'text-center py-3'},
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
                order: [[5, 'desc']],
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
                            url: `/admin/discount/${id}`,
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


          