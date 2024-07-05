<x-app-layout>
    <div class="pc-content">
        <div class="page-header">
            <div class="page-block">
                <div class="row align-items-center">
                    <div class="col-md-12">
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                            <li class="breadcrumb-item"><a href="#">Database</a></li>
                            <li class="breadcrumb-item" aria-current="page">Players</li>
                        </ul>
                    </div>
                    <div class="col-md-12">
                        <div class="page-header-title">
                            <h2 class="mb-0">Database Players</h2>
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
                                <h5>Database Players</h5>
                            </div>
                            <div class="col-md-6 text-end">
                                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#importPlayer">Import Player</button>
                            </div>
                        </div>
                    </div>
                    <div class="card-body table-border-style">
                        <div class="dt-responsive table-responsive">
                          <table id="simpletable" class="table table-striped table-bordered nowrap">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Player Name</th>
                                    <th>Position</th>
                                    <th>Team</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($players as $key => $item)
                                    <tr>
                                        <td>{{ $key+1 }}</td>
                                        <td>{{ $item->name }}</td>
                                        <td>{{ $item->position }}</td>
                                        <td>{{ $item->team->team_name }}</td>
                                        <td>
                                            {{-- <a href="#" class="avtar avtar-xs btn-link-secondary" data-bs-toggle="modal" data-bs-target="#editTeamModal{{ $item->id }}">
                                                <i class="ti ti-edit f-20"></i>
                                            </a>
                                            <a href="#" class="avtar avtar-xs btn-link-secondary" data-bs-toggle="modal" data-bs-target="#deleteTeamModal{{ $item->id }}">
                                                <i class="ti ti-trash f-20"></i>
                                            </a> --}}
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>

                          </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Add Division Modal -->
    <div id="importPlayer" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="importPlayer" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <form action="#" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title" id="addDivisionLabel">Import Player</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="mb-3 col-md-12">
                                <label class="form-label">Import Data</label>
                                <input type="file" name="import_data" class="form-control" id="inputGroupFile02">
                                <a class="mt-2" href="{{ asset('import.xlsx')}}">Download Sample File</a>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button class="btn btn-primary">Import</button>
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
            $('#simpletable').DataTable();
        </script>
    @endpush
</x-app-layout>
