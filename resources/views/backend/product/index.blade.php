@extends('backend.layouts.app')
@section('title', 'Product')
@section('content')
    <div class="card">
        <div class="card-body">
            <div class="mb-3">
                <a href="{{ route('product.create') }}" class="btn btn-theme"><i class="fa-solid fa-plus"></i> Create Product</a>
            </div>
            
            <div>
                <div>
                    <table class="table table-bordered w-100" id="product_table">
                        <thead>
                            <th></th>
                            <th class="py-3">Name</th>
                            <th class="py-3">Image</th>
                            <th class="py-3">Price (MMK)</th>
                            <th class="py-3">Qunantity</th>
                            <th class="py-3">Update At</th>
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
            let data_table = $('#product_table').DataTable({
                responsive: true,
                processing: true,
                serverSide: true,
                ajax: '/admin/product/data-table/ssd',
                columns: [
                    {data: 'plus-icon', name: 'plus-icon', class: 'text-center'},
                    {data: 'name', name: 'name', class: 'text-center py-3'},
                    {data: 'image', name: 'image', class: 'text-center d-flex justify-content-center align-items-center py-3'},
                    {data: 'price', name: 'price', class: 'text-center py-3'},
                    {data: 'quantity', name: 'quantity', class: 'text-center py-3'},
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
                            url: `/admin/product/${id}`,
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


          