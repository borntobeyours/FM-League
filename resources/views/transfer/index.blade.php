<x-app-layout>
    <div class="pc-content">
        <div class="page-header">
            <div class="page-block">
                <div class="row align-items-center">
                    <div class="col-md-12">
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                            <li class="breadcrumb-item" aria-current="page">Transfer Area</li>
                        </ul>
                    </div>
                    <div class="col-md-12">
                        <div class="page-header-title">
                            <h2 class="mb-0">Transfer Area</h2>
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
                                <h5>Transfer Area</h5>
                            </div>
                            <div class="col-md-6 text-end">
                                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addTransfer">add Transfer</button>
                            </div>
                        </div>
                    </div>
                    <div class="card-body table-border-style">
                        <div class="table-responsive">
                        <table id="simpletable" class="table table-striped table-bordered nowrap">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Player</th>
                                    <th>Transfer Date</th>
                                    <th>From</th>
                                    <th>To</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($transfer as $key => $item)
                                    <tr>
                                        <td>{{ $key+1 }}</td>
                                        <td>{{ $item->player->name }}</td>
                                        <td>{{ $item->transfer_date }}</td>
                                        <td>{{ Fungsi::get_team_from_id($item->from_team_id) }}</td>
                                        <td>{{ Fungsi::get_team_from_id($item->to_team_id) }}</td>
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

    <!-- Add Result Modal -->
    <div id="addTransfer" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="addResultLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl" role="document">
            <div class="modal-content">
                <form action="#" method="POST">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title" id="addResultLabel">Add Transfer</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="mb-3 col-md-12">
                                <label class="form-label">Transfer Date</label>
                                <input type="date" class="form-control" placeholder="Enter Result Name" name="transfer_date" required/>
                            </div>
                        </div>
                        <div class="row">
                            <div class="mb-3 col-md-12">
                                <label class="form-label">Player Name</label>
                                <select class="form-select" name="player_id" id="player_name" required>
                                    <option value="">Select Player</option>
                                    @foreach ($players as $item)
                                        <option value="{{ $item->id }}">
                                            {{ $item->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="row">
                            <div class="mb-3 col-md-6">
                                <label class="form-label">From Team</label>
                                <select class="form-select" name="from_team_id" id="from_team" required>
                                    <option value="">Select From Team</option>
                                    @foreach ($teams as $x)
                                        <option value="{{ $x->id }}">
                                            {{ $x->team_name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="mb-3 col-md-6">
                                <label class="form-label">To Team</label>
                                <select class="form-select" name="to_team_id" id="to_team" required>
                                    <option value="">Select To Team</option>
                                    <option value="999999">Terminated</option>
                                    @foreach ($teams as $y)
                                        <option value="{{ $y->id }}">
                                            {{ $y->team_name }}
                                        </option>
                                    @endforeach
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
