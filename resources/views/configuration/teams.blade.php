<x-app-layout>
    <div class="pc-content">
        <div class="page-header">
            <div class="page-block">
                <div class="row align-items-center">
                    <div class="col-md-12">
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                            <li class="breadcrumb-item"><a href="#">Configuration</a></li>
                            <li class="breadcrumb-item" aria-current="page">Teams</li>
                        </ul>
                    </div>
                    <div class="col-md-12">
                        <div class="page-header-title">
                            <h2 class="mb-0">Teams Databases</h2>
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
                                <h5>Teams Databases</h5>
                            </div>
                            <div class="col-md-6 text-end">
                                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addTeamModal">Add Team</button>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="dt-responsive table-responsive">
                            <table id="simpletable" class="table table-striped table-bordered nowrap">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Team Name</th>
                                        <th>Division</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($teams as $key => $item)
                                        <tr>
                                            <td>{{ $key+1 }}</td>
                                            <td>{{ $item->team_name }}</td>
                                            <td>{{ $item->division->division_name }}</td>
                                            <td>
                                                <a href="#" class="avtar avtar-xs btn-link-secondary" data-bs-toggle="modal" data-bs-target="#editTeamModal{{ $item->id }}">
                                                    <i class="ti ti-edit f-20"></i>
                                                </a>
                                                <a href="#" class="avtar avtar-xs btn-link-secondary" data-bs-toggle="modal" data-bs-target="#deleteTeamModal{{ $item->id }}">
                                                    <i class="ti ti-trash f-20"></i>
                                                </a>
                                            </td>
                                        </tr>

                                        <!-- Edit Team Modal -->
                                        <div id="editTeamModal{{ $item->id }}" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="editTeamLabel{{ $item->id }}" aria-hidden="true">
                                            <div class="modal-dialog" role="document">
                                                <div class="modal-content">
                                                    <form action="{{ route('config.teams.modify', $item->id) }}" method="POST">
                                                        @csrf
                                                        @method('PUT')
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="editTeamLabel{{ $item->id }}">Edit Team</h5>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <div class="row">
                                                                <div class="mb-3 col-md-12">
                                                                    <label class="form-label">Team Name</label>
                                                                    <input type="text" class="form-control" name="team_name" value="{{ $item->team_name }}" required/>
                                                                </div>
                                                            </div>
                                                            <div class="row">
                                                                <div class="mb-3 col-md-12">
                                                                    <label class="form-label">Team Division</label>
                                                                    <select class="form-select" name="division_id" required>
                                                                        @foreach ($divisions as $division)
                                                                            <option value="{{ $division->id }}" {{ $item->division_id == $division->id ? 'selected' : '' }}>
                                                                                {{ $division->division_name }}
                                                                            </option>
                                                                        @endforeach
                                                                    </select>
                                                                </div>
                                                            </div>
                                                            <div class="row">
                                                                <div class="mb-3 col-md-12">
                                                                    <label class="form-label">Playing</label>
                                                                    <select class="form-select" name="is_playing">
                                                                        <option value="1" {{ $item->is_playing ? 'selected' : '' }}>Yes</option>
                                                                        <option value="0" {{ !$item->is_playing ? 'selected' : '' }}>No</option>
                                                                    </select>
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

                                        <!-- Delete Team Modal -->
                                        <div id="deleteTeamModal{{ $item->id }}" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="deleteTeamLabel{{ $item->id }}" aria-hidden="true">
                                            <div class="modal-dialog" role="document">
                                                <div class="modal-content">
                                                    <form action="{{ route('config.teams.delete', $item->id) }}" method="POST">
                                                        @csrf
                                                        @method('DELETE')
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="deleteTeamLabel{{ $item->id }}">Delete Team</h5>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <p>Are you sure you want to delete the team "{{ $item->team_name }}"?</p>
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
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Add Team Modal -->
    <div id="addTeamModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="addTeamLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <form action="#" method="POST">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title" id="addTeamLabel">Add Team</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="mb-3 col-md-12">
                                <label class="form-label">Team Name</label>
                                <input type="text" class="form-control" placeholder="Enter Team Name" name="team_name" required/>
                            </div>
                        </div>
                        <div class="row">
                            <div class="mb-3 col-md-12">
                                <label class="form-label">Team Division</label>
                                <select class="form-select" name="division_id" required>
                                    <option value="">Select a Division</option>
                                    @foreach ($divisions as $division)
                                        <option value="{{ $division->id }}">
                                            {{ $division->division_name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="row">
                            <div class="mb-3 col-md-12">
                                <label class="form-label">Playing</label>
                                <select class="form-select" name="is_playing">
                                    <option value="1">Yes</option>
                                    <option value="0">No</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button class="btn btn-primary">Save</button>
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
