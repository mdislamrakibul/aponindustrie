@php
  $currentUser = \App\Models\User::where(
    'mobile_no',
    session('user_mobile')
  )->first();
@endphp
<nav class="main-header navbar navbar-expand navbar-white navbar-light">
  <!-- Left navbar links -->
  <ul class="navbar-nav">
    <li class="nav-item">
      <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
    </li>
  </ul>

  <!-- Right navbar links -->
  <ul class="navbar-nav ml-auto">

    <!-- MessSages Dropdown Menu -->
    @if(false)

      <li class="nav-item dropdown">
        <a class="#" data-toggle="dropdown" href="#">
          <i class="far fa-comments"></i>
          <span class="badge badge-danger navbar-badge">3</span>
        </a>

        <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
          <a href="#" class="dropdown-item">

            <div class="media">
              <img src="dist/img/user1-128x128.jpg" alt="User Avatar" class="img-size-50 mr-3 img-circle">

              <div class="media-body">
                <h3 class="dropdown-item-title">
                  Brad Diesel
                  <span class="float-right text-sm text-danger">
                    <i class="fas fa-star"></i>
                  </span>
                </h3>

                <p class="text-sm">Call me whenever you can...</p>

                <p class="text-sm text-muted">
                  <i class="far fa-clock mr-1"></i> 4 Hours Ago
                </p>
              </div>
            </div>

          </a>
        </div>
      </li>

      <!-- Message End -->
      </a>
      <div class="dropdown-divider"></div>
      <a href="#" class="dropdown-item">
        <!-- Message Start -->
        <div class="media">
          <img src="dist/img/user8-128x128.jpg" alt="User Avatar" class="img-size-50 img-circle mr-3">
          <div class="media-body">
            <h3 class="dropdown-item-title">
              John Pierce
              <span class="float-right text-sm text-muted"><i class="fas fa-star"></i></span>
            </h3>
            <p class="text-sm">I got your message bro</p>
            <p class="text-sm text-muted"><i class="far fa-clock mr-1"></i> 4 Hours Ago</p>
          </div>
        </div>
        <!-- Message End -->
      </a>
      <div class="dropdown-divider"></div>
      <a href="#" class="dropdown-item">
        <!-- Message Start -->
        <div class="media">
          <img src="dist/img/user3-128x128.jpg" alt="User Avatar" class="img-size-50 img-circle mr-3">
          <div class="media-body">
            <h3 class="dropdown-item-title">
              Nora Silvester
              <span class="float-right text-sm text-warning"><i class="fas fa-star"></i></span>
            </h3>
            <p class="text-sm">The subject goes here</p>
            <p class="text-sm text-muted"><i class="far fa-clock mr-1"></i> 4 Hours Ago</p>
          </div>
        </div>
        <!-- Message End -->
      </a>
      <div class="dropdown-divider"></div>
      <a href="#" class="dropdown-item dropdown-footer">See All Messages</a>
      </div>
      </li>
    @endif

    {{-- Notifications Dropdown Menu — admin only (e.g. cashier password changes) --}}
    @if(session('user_role') === 'admin')
      @php
        $adminNotifications = \App\Models\Notification::where('target_role', 'admin')->latest()->take(10)->get();
        $unreadNotificationCount = $adminNotifications->where('is_read', false)->count();
      @endphp
      <li class="nav-item dropdown" id="notificationBellItem">
        <a class="nav-link" data-toggle="dropdown" href="#" id="notificationBellToggle">
          <i class="far fa-bell"></i>
          @if($unreadNotificationCount > 0)
            <span class="badge badge-warning navbar-badge">{{ $unreadNotificationCount }}</span>
          @endif
        </a>
        <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
          <span class="dropdown-item dropdown-header">Notifications</span>
          @forelse($adminNotifications as $note)
            <div class="dropdown-divider"></div>
            <div class="dropdown-item {{ $note->is_read ? '' : 'font-weight-bold' }}" style="white-space: normal;">
              <i class="fas fa-key mr-2"></i>{{ $note->title }}
              <p class="text-sm text-muted mb-0">{{ $note->message }}</p>
              <span class="text-muted text-sm">{{ $note->created_at->diffForHumans() }}</span>
            </div>
          @empty
            <div class="dropdown-divider"></div>
            <span class="dropdown-item text-muted">No notifications</span>
          @endforelse
        </div>
      </li>
      <script>
        (function () {
          var toggle = document.getElementById('notificationBellToggle');
          if (!toggle) return;
          toggle.addEventListener('click', function () {
            fetch('{{ route('admin.notifications.read-all') }}', {
              method: 'POST',
              headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Accept': 'application/json',
              },
            }).then(function () {
              var badge = document.querySelector('#notificationBellItem .navbar-badge');
              if (badge) badge.remove();
            });
          }, { once: true });
        })();
      </script>
    @endif


    <div class="btn-group">
      <button type="button" class="btn btn-primary " data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
        <div class="user-panel d-flex">
          <div class="image">
            <img src="{{
  $currentUser && $currentUser->profile_photo
    ? asset($currentUser->profile_photo)
    : asset('admin/dist/img/user2-160x160.jpg')
}}" class="img-circle elevation-2" alt="User Image">
          </div>
          <div class="info">
            <a href="#" class="d-block text-white">
              {{ $currentUser?->first_name }}
              {{ $currentUser?->last_name }}
            </a>
          </div>
        </div>
      </button>
      <button type="button" class="btn btn-primary dropdown-toggle dropdown-toggle-split" data-toggle="dropdown"
        aria-haspopup="true" aria-expanded="false">
        <span class="sr-only">Toggle Dropdown</span>
      </button>
      <div class="dropdown-menu">
        <a class="dropdown-item" href="{{ route('admin.profile') }}">
          <span style="
          gap: 10px;
          display: flex;
          align-items: center;"><i class="fas fa-user-circle" style="color: blue"></i> Profile</span>
        </a>
        {{-- <a class="dropdown-item" href="#">Another action</a>
        <a class="dropdown-item" href="#">Something else here</a> --}}
        <div class="dropdown-divider"></div>
        <a href="#" class="nav-link text-danger"
          onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
          <span style="
          gap: 10px;
          display: flex;
          align-items: center;">
            <i class="fas fa-sign-out-alt"></i>
            Logout
          </span>
        </a>

        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
          @csrf
        </form>
      </div>
    </div>






  </ul>
</nav>
<!-- /.navbar -->