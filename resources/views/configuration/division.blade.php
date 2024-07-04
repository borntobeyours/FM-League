<x-app-layout>
    <div class="pc-content">
        <div class="page-header">
            <div class="page-block">
                <div class="row align-items-center">
                    <div class="col-md-12">
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                            <li class="breadcrumb-item"><a href="#">Configuration</a></li>
                            <li class="breadcrumb-item" aria-current="page">League Division</li>
                        </ul>
                    </div>
                    <div class="col-md-12">
                        <div class="page-header-title">
                            <h2 class="mb-0">League Division</h2>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-header">
                        <div class="row">
                            <div class="col-md-6">
                                <h5>League Division</h5>
                            </div>
                            <div class="col-md-6 text-end">
                                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addDivisionModal">Add Division</button>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="dt-responsive table-responsive">
                            <table id="simpletable" class="table table-striped table-bordered nowrap">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Division Name</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($data as $key => $item)
                                        <tr>
                                            <td>{{ $key+1 }}</td>
                                            <td>{{ $item->division_name }}</td>
                                            <td>
                                                <a href="#" class="avtar avtar-xs btn-link-secondary" data-bs-toggle="modal" data-bs-target="#editDivisionModal{{ $item->id }}">
                                                  <i class="ti ti-edit f-20"></i>
                                                </a>
                                                <a href="#" class="avtar avtar-xs btn-link-secondary" data-bs-toggle="modal" data-bs-target="#deleteDivisionModal{{ $item->id }}">
                                                  <i class="ti ti-trash f-20"></i>
                                                </a>
                                            </td>
                                        </tr>

                                        <!-- Edit Division Modal -->
                                        <div id="editDivisionModal{{ $item->id }}" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="editDivisionLabel{{ $item->id }}" aria-hidden="true">
                                            <div class="modal-dialog" role="document">
                                                <div class="modal-content">
                                                    <form action="{{ route('config.division.modify', $item->id) }}" method="POST">
                                                        @csrf
                                                        @method('PUT')
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="editDivisionLabel{{ $item->id }}">Edit Division</h5>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <div class="row">
                                                                <div class="mb-3 col-md-12">
                                                                    <label class="form-label">Division Name</label>
                                                                    <input type="text" class="form-control" placeholder="Enter Division Name" name="division_name" value="{{ $item->division_name }}" required/>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                            <button class="btn btn-primary">Save changes</button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Delete Division Modal -->
                                        <div id="deleteDivisionModal{{ $item->id }}" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="deleteDivisionLabel{{ $item->id }}" aria-hidden="true">
                                            <div class="modal-dialog" role="document">
                                                <div class="modal-content">
                                                    <form action="{{ route('config.division.delete', $item->id) }}" method="POST">
                                                        @csrf
                                                        @method('DELETE')
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="deleteDivisionLabel{{ $item->id }}">Delete Division</h5>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <p>Are you sure you want to delete the division "{{ $item->division_name }}"?</p>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                            <button class="btn btn-danger">Delete</button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th>No</th>
                                        <th>Division Name</th>
                                        <th>Status</th>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Add Division Modal -->
    <div id="addDivisionModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="addDivisionLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <form action="#" method="POST">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title" id="addDivisionLabel">Add Division</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="mb-3 col-md-12">
                                <label class="form-label">Division Name</label>
                                <input type="text" class="form-control" placeholder="Enter Division Name" name="division_name" required/>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button class="btn btn-primary">Save changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    @section('css')
        <link rel="stylesheet" href="{{ asset('/assets/css/plugins/dataTables.bootstrap5.min.css') }}" />
    @endsection

    @push('scripts')
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
        <script src="{{ asset('/assets/js/plugins/dataTables.min.js') }}"></script>
        <script src="{{ asset('/assets/js/plugins/dataTables.bootstrap5.min.js') }}"></script>
        <script>
            $(document).ready(function() {
                $('#simpletable').DataTable();
            });
        </script>
    @endpush
</x-app-layout>
