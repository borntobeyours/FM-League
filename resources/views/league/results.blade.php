<x-app-layout>
    <div class="pc-content">
        <div class="page-header">
            <div class="page-block">
                <div class="row align-items-center">
                    <div class="col-md-12">
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                            <li class="breadcrumb-item"><a href="#">{{ $division->division_name }}</a></li>
                            <li class="breadcrumb-item" aria-current="page">Results</li>
                        </ul>
                    </div>
                    <div class="col-md-12">
                        <div class="page-header-title">
                            <h2 class="mb-0">{{ $division->division_name }} Results</h2>
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
                                <h5>{{ $division->division_name }} Results</h5>
                            </div>
                            <div class="col-md-6 text-end">
                                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addResultModal">Add Result</button>
                            </div>
                        </div>
                    </div>
                    <div class="card-body table-border-style">
                        <div class="table-responsive">
                          <table class="table table-styling">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Match Date</th>
                                    <th>Home Team</th>
                                    <th>Away Team</th>
                                    <th>Score</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($results as $key=>$item)
                                    <tr>
                                        <td>{{ $key+1 }}</td>
                                        <td>{{ $item->match_date}}</td>
                                        <td>{{ Fungsi::get_team_from_league($item->home_league_id) }}</td>
                                        <td>{{ Fungsi::get_team_from_league($item->away_league_id) }}</td>
                                        <td>{{ $item->home_score}} - {{ $item->away_score}}</td>
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
    <div id="addResultModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="addResultLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl" role="document">
            <div class="modal-content">
                <form action="#" method="POST">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title" id="addResultLabel">Add Result</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="mb-3 col-md-12">
                                <label class="form-label">Match Date</label>
                                <input type="date" class="form-control" placeholder="Enter Result Name" name="match_date" required/>
                            </div>
                        </div>
                        <div class="row">
                            <div class="mb-3 col-md-6">
                                <label class="form-label">Home Team</label>
                                <select class="form-select" name="home_team" id="home_team" required>
                                    <option value="">Select Home Team</option>
                                    @foreach ($league as $team)
                                        <option value="{{ $team->id }}">
                                            {{ $team->team->team_name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="mb-3 col-md-6">
                                <label class="form-label">Away Team</label>
                                <select class="form-select" name="away_team" id="away_team" required>
                                    <option value="">Select Away Team</option>
                                    @foreach ($league as $team)
                                        <option value="{{ $team->id }}">
                                            {{ $team->team->team_name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="row">
                            <div class="mb-3 col-md-6">
                                <label class="form-label">Score Home</label>
                                <input type="number" class="form-control" placeholder="Enter Score Home" name="score_home" required/>
                            </div>
                            <div class="mb-3 col-md-6">
                                <label class="form-label">Score Away</label>
                                <input type="number" class="form-control" placeholder="Enter Score Away" name="score_away" required/>
                            </div>
                        </div>
                        <div class="row">
                            <div class="mb-3 col-md-6">
                                <label class="form-label">Goal Score Home</label>
                                <div id="goal_home_container"></div>
                            </div>
                            <div class="mb-3 col-md-6">
                                <label class="form-label">Goal Score Away</label>
                                <div id="goal_away_container"></div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="mb-3 col-md-6">
                                <label class="form-label">Assist Home</label>
                                <div id="assist_home_container"></div>
                            </div>
                            <div class="mb-3 col-md-6">
                                <label class="form-label">Assist Away</label>
                                <div id="assist_away_container"></div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="mb-3 col-md-6">
                                <label class="form-label">Yellow Card Home</label>
                                <div id="yellow_card_home_container"></div>
                            </div>
                            <div class="mb-3 col-md-6">
                                <label class="form-label">Yellow Card Away</label>
                                <div id="yellow_card_away_container"></div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="mb-3 col-md-6">
                                <label class="form-label">Red Card Home</label>
                                <div id="red_card_home_container"></div>
                            </div>
                            <div class="mb-3 col-md-6">
                                <label class="form-label">Red Card Away</label>
                                <div id="red_card_away_container"></div>
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
    @endsection

    @push('scripts')
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                // Handle home team change
                document.getElementById('home_team').addEventListener('change', function () {
                    let teamId = this.value;
                    updatePlayerDropdowns('goal_home_container', teamId, 'goal_home');
                    updatePlayerDropdowns('assist_home_container', teamId, 'assist_home');
                    updatePlayerDropdowns('yellow_card_home_container', teamId, 'yellow_card_home');
                    updatePlayerDropdowns('red_card_home_container', teamId, 'red_card_home');
                });

                // Handle away team change
                document.getElementById('away_team').addEventListener('change', function () {
                    let teamId = this.value;
                    updatePlayerDropdowns('goal_away_container', teamId, 'goal_away');
                    updatePlayerDropdowns('assist_away_container', teamId, 'assist_away');
                    updatePlayerDropdowns('yellow_card_away_container', teamId, 'yellow_card_away');
                    updatePlayerDropdowns('red_card_away_container', teamId, 'red_card_away');
                });

                function updatePlayerDropdowns(containerId, teamId, inputName) {
                    let container = document.getElementById(containerId);
                    container.innerHTML = '';

                    if (teamId) {
                        fetch(`/database/players/${teamId}`)
                            .then(response => response.json())
                            .then(data => {
                                data.forEach(player => {
                                    let div = document.createElement('div');
                                    div.classList.add('mb-3', 'd-flex', 'align-items-center');

                                    let label = document.createElement('label');
                                    label.classList.add('form-label', 'me-2');
                                    label.textContent = player.name;

                                    let input = document.createElement('input');
                                    input.type = 'number';
                                    input.classList.add('form-control', 'me-2');
                                    input.name = `${inputName}[${player.id}]`;
                                    input.placeholder = '0';
                                    input.min = '0';

                                    div.appendChild(label);
                                    div.appendChild(input);
                                    container.appendChild(div);
                                });
                            });
                    }
                }
            });
        </script>
    @endpush
</x-app-layout>
