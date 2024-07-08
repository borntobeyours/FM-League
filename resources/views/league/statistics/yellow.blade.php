<x-app-layout>
    <div class="pc-content">
        <div class="page-header">
            <div class="page-block">
                <div class="row align-items-center">
                    <div class="col-md-12">
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                            <li class="breadcrumb-item"><a href="#">{{ $division->division_name }}</a></li>
                            <li class="breadcrumb-item"><a href="#">Statistics</a></li>
                            <li class="breadcrumb-item" aria-current="page">Yellow Card</li>
                        </ul>
                    </div>
                    <div class="col-md-12">
                        <div class="page-header-title">
                            <h2 class="mb-0">{{ $division->division_name }} Yellow Card</h2>
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
                                <h5>{{ $division->division_name }} Yellow Card</h5>
                            </div>
                        </div>
                    </div>
                    <div class="card-body table-border-style">
                        <div class="table-responsive">
                          <table class="table table-styling">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Player</th>
                                    <th>Team</th>
                                    <th>Yellow Card</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($yellow as $key => $item)
                                    <tr>
                                        <td>{{ $key+1 }}</td>
                                        <td>{{ $item->player->name }}</td>
                                        <td>{{ $item->team->team_name }}</td>
                                        <td>{{ $item->yellow_card }}</td>
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

    @section('css')
    @endsection

    @push('scripts')
    @endpush
</x-app-layout>
