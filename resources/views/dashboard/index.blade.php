@extends('layouts.master')

@section('content')
    <div class="container-fluid mt-4">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between">
                        <h3>Employee List</h3>
                        <button onclick="addForm('{{ route('store-employee') }}')" class="btn btn-success btn-sm"><i
                                class="fa fa-plus-circle">Add
                                Data</i></button>
                    </div>
                    {{-- <form action="" class="row mt-2">
                        <div class="col-6">
                            <input type="date" id="start_date_input" name="start_date" class="form-control mr-4">
                        </div>
                        <div class="col-6">
                            <input type="date" id="end_date_input" name="end_date" class="form-control">
                        </div>
                        <div class="my-2 mx-1 row">
                            <button id="filter" class="btn btn-success btn-sm"><i
                                    class="fa fa-plus-circle">Filter</i></button>
                        </div>
                    </form> --}}
                    <div class="card-body">
                        <div class="table-responsive-md">
                            <table class="table table-bordered" id="example">
                                <thead>
                                    <tr>
                                        <th scope="col" style="text-align: center">No</th>
                                        <th scope="col" style="text-align: center">Name</th>
                                        <th scope="col" style="text-align: center">Phone</th>
                                        <th scope="col" style="text-align: center">Join Date</th>
                                        <th scope="col" style="text-align: center">Address</th>
                                        <th scope="col" style="text-align: center">Gender</th>
                                        <th scope="col" style="text-align: center">Department</th>
                                        <th scope="col" style="text-align: center">Action</th>
                                    </tr>
                                </thead>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Edit Data  -->
    @includeIf('dashboard.form')
@endsection

@push('script')
    <script>
        let table;
        let param1;
        let param2;

        $(document).ready(function() {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            table = $('.table').DataTable({
                responsive: true,
                fixedHeader: true,
                // buat menghilangkan sortable pada nomor
                columnDefs: [{
                        orderable: false,
                        targets: 0,
                    },
                    {
                        className: 'dt-center',
                        targets: '_all'
                    }
                ],
                processing: true,
                serverSide: true,
                autowidth: false,
                ajax: {
                    url: "{{ route('data-employee') }}",
                    type: 'GET',
                },
                columns: [{
                        // buat penomoran
                        data: 'DT_RowIndex',
                        searchable: false,
                        orderable: false
                    },
                    {
                        data: 'name'
                    },
                    {
                        data: 'phone_number'
                    },

                    {
                        data: 'date_of_joining'
                    },
                    {
                        data: 'address'
                    },
                    {
                        data: 'gender'
                    },
                    {
                        data: 'department_name'
                    },
                    {
                        data: 'action',
                        name: 'action',
                        searchable: false,
                        sortable: false
                    },
                ]
            });
        });

        function editForm(url) {
            // buat mengosongkan error listnya terlebih dahulu
            $('#error_list').html('')
            $('#error_list').removeClass('alert alert-danger')

            // buat menampilkan modal
            $('#modal-form').modal('show')
            $('#modal-form .modal-title').html('Edit Data Kategori')

            // buat aksi ke method update
            var updateUrl = url.replace('edit', 'update');
            $('#modal-form form').attr('action', updateUrl);
            $('#modal-form [name=_method]').val('PUT');


            $.get(url)
                .done((response) => {
                    console.log(response);
                    $('#name').val(response.name)
                    $('#phone_number').val(response.phone_number)
                    $('#address').val(response.address)
                    $('#date_of_birth').val(response.date_of_birth)
                    $('#date_of_joining').val(response.date_of_joining)
                    $('#gender').val(response.gender)
                    $('#department').val(response.department.department_id)
                })
        }

        function deleteData(url) {
            swal({
                    title: "Are you sure?",
                    text: "Once deleted, you will not be able to recover this data!",
                    icon: "warning",
                    buttons: true,
                    dangerMode: true,
                })
                .then((willDelete) => {
                    if (willDelete) {
                        $.ajax({
                                url: url,
                                method: 'DELETE',
                            })
                            .done((response) => {
                                swal("Success data has been deleted!", {
                                    icon: "success",
                                });
                                table.ajax.reload();
                            })
                            .fail((errors) => {
                                swal("Failed deleted data!", {
                                    icon: "warning",
                                });
                                return;
                            });

                    } else {
                        swal("Data is safe!");
                    }
                });
        }


        function addForm(url) {
            $('#modal-form').modal('show')
            $('#modal-form .modal-title').html('Add Data Employee')

            // buat mengosongkan error listnya terlebih dahulu
            $('#error_list').html('')
            $('#error_list').removeClass('alert alert-danger')

            $('#modal-form form')[0].reset()
            $('#modal-form form').attr('action', url)
            $('#modal-form [name=_method]').val('post')
        }

        $('#modal-form form').on('submit', function(e) {
            e.preventDefault()
            $.post($('#modal-form form').attr('action'), $('#modal-form form').serialize())
                .done((response) => {
                    if (response.message == 'Success Added Data' || response.message ==
                        'Success Updated Data') {
                        $('#modal-form').modal('hide');
                        swal({
                            title: "Success!",
                            text: response.message,
                            icon: "success",
                            button: "Ok!",
                        });
                        table.ajax.reload()
                    } else if (response.status == 'Failed added' || response.status ==
                        'Failed updated') {
                        $('#error_list').html('')
                        $('#error_list').addClass('alert alert-danger')
                        $.each(response.errors, function(key, value) {
                            $('#error_list').append('<li>' + value + '</li>')
                        })
                    }
                })
        })
    </script>
@endpush
