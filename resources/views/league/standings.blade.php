<x-app-layout>
    <div class="pc-content">
        <div class="page-header">
            <div class="page-block">
                <div class="row align-items-center">
                    <div class="col-md-12">
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                            <li class="breadcrumb-item"><a href="#">{{ $league->division_name }}</a></li>
                            <li class="breadcrumb-item" aria-current="page">Standings</li>
                        </ul>
                    </div>
                    <div class="col-md-12">
                        <div class="page-header-title">
                            <h2 class="mb-0">{{ $league->division_name }} Standings</h2>
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
                                <h5>{{ $league->division_name }} Standings</h5>
                            </div>
                        </div>
                    </div>
                    <div class="card-body table-border-style">
                        <div class="table-responsive">
                          <table class="table table-styling">
                            <thead>
                              <tr>
                                <th>Rank</th>
                                <th>First Name</th>
                                <th>Last Name</th>
                                <th>Username</th>
                              </tr>
                            </thead>
                            <tbody>
                              <tr>
                                <td>1</td>
                                <td>Mark</td>
                                <td>Otto</td>
                                <td>@mdo</td>
                              </tr>
                              <tr>
                                <td>2</td>
                                <td>Jacob</td>
                                <td>Thornton</td>
                                <td>@fat</td>
                              </tr>
                            </tbody>
                            <tfoot class="table-info">
                              <tr>
                                <td>#</td>
                                <td>Larry</td>
                                <td>the Bird</td>
                                <td>@twitter</td>
                              </tr>
                            </tfoot>
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
