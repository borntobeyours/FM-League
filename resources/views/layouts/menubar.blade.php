<div class="card pc-user-card">
    <div class="card-body">
        <div class="d-flex align-items-center">
            <div class="flex-shrink-0">
                <img src="https://eu.ui-avatars.com/api/?background=0D8ABC&color=fff&name={{ Auth::user()->name }}" alt="user-image" class="user-avtar wid-45 rounded-circle" />
            </div>
            <div class="flex-grow-1 ms-3 me-2">
                <h6 class="mb-0">{{ Auth::user()->name }}</h6>
                <small>Administrator</small>
            </div>
            <a class="btn btn-icon btn-link-secondary avtar" data-bs-toggle="collapse" href="#pc_sidebar_userlink">
                <svg class="pc-icon">
                    <use xlink:href="#custom-sort-outline"></use>
                </svg>
            </a>
        </div>
        <div class="collapse pc-user-links" id="pc_sidebar_userlink">
            <div class="pt-3">
                <a href="{{ route('profile.edit') }}">
                    <i class="ti ti-user"></i>
                    <span>My Account</span>
                </a>
                <a href="#!" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                    <i class="ti ti-power"></i>
                    <span>Logout</span>
                </a>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                    @csrf
                </form>
            </div>
        </div>
    </div>
</div>

<ul class="pc-navbar">
    <li class="pc-item pc-caption">
        <label>FM Team Management</label>
    </li>
    <li class="pc-item">
        <a href="{{ route('dashboard') }}" class="pc-link">
            <span class="pc-micon">
                <svg class="pc-icon">
                    <use xlink:href="#custom-status-up"></use>
                </svg>
            </span>
            <span class="pc-mtext">Dashboard</span>
        </a>
    </li>
    <li class="pc-item">
        <a href="#" class="pc-link">
            <span class="pc-micon">
                <svg class="pc-icon">
                    <use xlink:href="#custom-user-add"></use>
                </svg>
            </span>
            <span class="pc-mtext">Transfer</span>
        </a>
    </li>

    <li class="pc-item pc-caption">
        <label>League</label>
    </li>
    <li class="pc-item">
        <a href="#" class="pc-link">
            <span class="pc-micon">
                <svg class="pc-icon">
                    <use xlink:href="#custom-layer"></use>
                </svg>
            </span>
            <span class="pc-mtext">Classement</span>
        </a>
    </li>
    <li class="pc-item">
        <a href="#" class="pc-link">
            <span class="pc-micon">
                <svg class="pc-icon">
                    <use xlink:href="#custom-presentation-chart"></use>
                </svg>
            </span>
            <span class="pc-mtext">Statistics</span>
        </a>
    </li>
    <li class="pc-item">
        <a href="#" class="pc-link">
            <span class="pc-micon">
                <svg class="pc-icon">
                    <use xlink:href="#custom-video-play"></use>
                </svg>
            </span>
            <span class="pc-mtext">Match Result</span>
        </a>
    </li>

    <li class="pc-item pc-caption">
        <label>Cup</label>
    </li>
    <li class="pc-item">
        <a href="#" class="pc-link">
            <span class="pc-micon">
                <svg class="pc-icon">
                    <use xlink:href="#custom-layer"></use>
                </svg>
            </span>
            <span class="pc-mtext">Classement</span>
        </a>
    </li>
    <li class="pc-item">
        <a href="#" class="pc-link">
            <span class="pc-micon">
                <svg class="pc-icon">
                    <use xlink:href="#custom-presentation-chart"></use>
                </svg>
            </span>
            <span class="pc-mtext">Statistics</span>
        </a>
    </li>
    <li class="pc-item">
        <a href="#" class="pc-link">
            <span class="pc-micon">
                <svg class="pc-icon">
                    <use xlink:href="#custom-video-play"></use>
                </svg>
            </span>
            <span class="pc-mtext">Match Result</span>
        </a>
    </li>

    <li class="pc-item pc-caption">
        <label>My Team</label>
    </li>
    <li class="pc-item">
        <a href="#" class="pc-link">
            <span class="pc-micon">
                <svg class="pc-icon">
                    <use xlink:href="#custom-presentation-chart"></use>
                </svg>
            </span>
            <span class="pc-mtext">Player Statistics</span>
        </a>
    </li>

    <li class="pc-item pc-caption">
        <label>Admin Panel</label>
    </li>

    <li class="pc-item pc-hasmenu">
        <a href="#!" class="pc-link">
            <span class="pc-micon">
                <svg class="pc-icon">
                    <use xlink:href="#custom-cpu-charge"></use>
                </svg>
            </span>
            <span class="pc-mtext">Configuration</span><span class="pc-arrow"><i data-feather="chevron-right"></i></span>
        </a>
        <ul class="pc-submenu">
            <li class="pc-item"><a class="pc-link" href="{{ route('config.league') }}">League & Cup</a></li>
            <li class="pc-item"><a class="pc-link" href="{{ route('config.division') }}">League Division</a></li>
            <li class="pc-item"><a class="pc-link" href="{{ route('config.teams') }}">Teams Database</a></li>
        </ul>
    </li>
</ul>
