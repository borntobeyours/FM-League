<x-app-layout>
    <div class="pc-content">
        <div class="page-header">
            <div class="page-block">
                <div class="row align-items-center">
                    <div class="col-md-12">
                        <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="#">Configuration</a></li>
                        <li class="breadcrumb-item" aria-current="page">League and Cup</li>
                        </ul>
                    </div>
                    <div class="col-md-12">
                        <div class="page-header-title">
                        <h2 class="mb-0">League and Cup Configuration</h2>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-body">
                        <form action="#" method="POST">
                            @csrf
                            <div class="row">
                                <div class="mb-3 col-md-12">
                                    <label class="form-label">Event Name</label>
                                    <input type="text" class="form-control" placeholder="Enter Event Name" name="event_name" value="{{ $data->event_name ?? null }}" required/>
                                </div>
                            </div>
                            <div class="row">
                                <div class="mb-3 col-md-12">
                                    <label class="form-label">Event Year</label>
                                    <input type="text" class="form-control" placeholder="Event Year" name="event_year" value="{{ $data->event_year ?? null }}" required/>
                                </div>
                            </div>
                            <div class="row">
                                <div class="mb-3 col-md-12">
                                    <label class="form-label">Event Season</label>
                                    <input type="text" class="form-control" placeholder="Event Season" name="event_season" value="{{ $data->event_season ?? null }}" required/>
                                </div>
                            </div>
                            <hr>
                            <div class="row">
                                <div class="col-md-12">
                                    <h4>
                                        League Configuration
                                    </h4>
                                </div>
                            </div>
                            <div class="row">
                                <div class="mb-3 col-md-12">
                                    <label class="form-label">League Name</label>
                                    <input type="text" class="form-control" placeholder="Enter League Name" name="league_name" value="{{ $data->league_name ?? null }}" required/>
                                </div>
                            </div>
                            <hr>
                            <div class="row">
                                <div class="col-md-12">
                                    <h4>
                                        Cup Configuration
                                    </h4>
                                </div>
                            </div>
                            <div class="row">
                                <div class="mb-3 col-md-12">
                                    <label class="form-label">Cup Name</label>
                                    <input type="text" class="form-control" placeholder="Enter Cup Name" name="cup_name" value="{{ $data->cup_name ?? null }}" required/>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="mt-4 text-end btn-page">
                                        <button class="btn btn-primary">Save</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
