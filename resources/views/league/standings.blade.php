<x-app-layout>
    <div class="pc-content">
        <div class="page-header">
            <div class="page-block">
                <div class="row align-items-center">
                    <div class="col-md-12">
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                            <li class="breadcrumb-item"><a href="#">{{ $division->division_name }}</a></li>
                            <li class="breadcrumb-item" aria-current="page">Standings</li>
                        </ul>
                    </div>
                    <div class="col-md-12">
                        <div class="page-header-title">
                            <h2 class="mb-0">{{ $division->division_name }} Standings</h2>
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
                                <h5>{{ $division->division_name }} Standings</h5>
                            </div>
                        </div>
                    </div>
                    <div class="card-body table-border-style">
                        <div class="table-responsive">
                          <table class="table table-styling">
                            <thead>
                                <tr>
                                    <th>Rank</th>
                                    <th>Team</th>
                                    <th>MP</th>
                                    <th>W</th>
                                    <th>D</th>
                                    <th>L</th>
                                    <th>GF</th>
                                    <th>GA</th>
                                    <th>GD</th>
                                    <th>Pts</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($standings as $key => $item)
                                    @php
                                        $rank = $key + 1;
                                        $rowClass = '';

                                        if ($rank == 1) {
                                            $rowClass = 'table-success';
                                        } elseif ($rank >= 10 && $rank <= 12 && in_array($item->division_id, [1, 3])) {
                                            $rowClass = 'table-danger';
                                        } elseif ($rank >= 2 && $rank <= 3 && $item->division_id == 3) {
                                            $rowClass = 'table-info';
                                        } elseif ($rank == 2 && in_array($item->division_id, [4, 5])) {
                                            $rowClass = 'bg-yellow-100';
                                        } elseif ($rank == 12 && in_array($item->division_id, [4, 5])) {
                                            $rowClass = 'table-danger';
                                        }
                                    @endphp

                                    <tr class="{{ $rowClass }}">
                                        <td>{{ $rank }}</td>
                                        <td>{{ $item->team->team_name }}</td>
                                        <td>{{ $item->mp }}</td>
                                        <td>{{ $item->w }}</td>
                                        <td>{{ $item->d }}</td>
                                        <td>{{ $item->l }}</td>
                                        <td>{{ $item->gf }}</td>
                                        <td>{{ $item->ga }}</td>
                                        <td>{{ $item->gf - $item->ga }}</td>
                                        <td>{{ $item->pts }}</td>
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
