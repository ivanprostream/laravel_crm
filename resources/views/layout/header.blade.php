<!-- Navbar -->
  <nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
      </li>

      @if(\Auth::user()->is_admin == 1)
        <li class="nav-item d-none d-sm-inline-block">
          <a href="{{ url('/admin/divisions') }}" class="nav-link">Подразделения</a>
        </li>
      @endif
      
    </ul>



    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">

       <!-- Notifications Dropdown Menu -->
      <li class="nav-item dropdown">
        <a class="nav-link" data-toggle="dropdown" href="#">
          <i class="far fa-bell"></i>
          <span class="badge badge-warning navbar-badge">{{ count(getUnreadChatMessages()) }}</span>
        </a>
        <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
          <span class="dropdown-item dropdown-header">сообщений в чате</span>

          @foreach(getUnreadChatMessages() as $chatId)
          <div class="dropdown-divider"></div>
          <a href="{{ url('/admin/tasks/' . $chatId['task_id']) }}" class="dropdown-item">
            <i class="fas fa-users mr-2"></i> {{ $chatId['name'] }}
          </a>
          @endforeach

        </div>
      </li>

      <!-- Messages: style can be found in dropdown.less-->
 
      <li class="nav-item dropdown">
        <a class="nav-link" data-toggle="dropdown" href="#">
          <i class="far fa-comments"></i>
          <span class="badge badge-danger navbar-badge">{{ count(getUnreadMessages()) }}</span>
        </a>

        <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">

          @foreach(getUnreadMessages() as $message)
          <a href="{{ url('/admin/mailbox-show/' . $message->id) }}" class="dropdown-item">
            <!-- Message Start -->
            <div class="media">
              @if(!empty($message->sender->image) && file_exists(public_path('uploads/users/' . $message->sender->image)))
                  <img src="{{ url('public/uploads/users/' . $message->sender->image) }}" class="img-size-50 mr-3 img-circle">
              @else
                  <img src="{{ url('public/theme/dist/img/image_placeholder.png') }}" class="img-size-50 mr-3 img-circle">
              @endif

             
              <div class="media-body">
                <h3 class="dropdown-item-title">
                  {{ $message->sender->name }}
                </h3>
                <p class="text-sm">{{ $message->subject }}</p>
                <p class="text-sm text-muted"><i class="far fa-clock mr-1"></i> {{ Carbon\Carbon::parse($message->time_sent)->diffForHumans() }}</p>
              </div>
            </div>
            <!-- Message End -->
          </a>
          <div class="dropdown-divider"></div>
          @endforeach
          <a href="{{ url('admin/mailbox/Inbox') }}" class="dropdown-item dropdown-footer">Смотреть все</a>
        </div>
      </li>

      <li class="nav-item dropdown">
        <a class="nav-link" href="{{ url('/admin/my-profile') }}">
          <i class="far fa-user-circle"></i> Профайл
        </a>
      </li>

      <li class="nav-item dropdown">

        <a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" class="nav-link">
          <i class="fas fa-sign-out-alt"></i> Выход
        </a>

        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
            @csrf
        </form>

      </li>
      
    </ul>
  </nav>
  <!-- /.navbar -->

