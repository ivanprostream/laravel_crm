<!-- Main Sidebar Container -->
  <aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="{{ url('/admin') }}" class="brand-link">
      <img src="{{ asset('public/theme/dist/img/AdminLTELogo.png') }}" alt="{{ config('app.name', 'Laravel') }}" class="brand-image img-circle elevation-3"
           style="opacity: .8">
      <span class="brand-text font-weight-light">{{ config('app.name', 'Laravel') }}</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar user panel (optional) -->
      <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="image">
          @if(\Auth::user()->image != null)
              <img src="{{ url('public/uploads/users/' . \Auth::user()->image) }}" class="img-circle" alt="User Image">
          @else
              <img src="{{ url('theme/dist/img/avatar5.png') }}" class="img-circle" alt="User Image">
          @endif
        </div>
        <div class="info">
          <a href="{{ url('/admin/my-profile') }}" class="d-block">{{ \Auth::user()->name }}</a>
        </div>
      </div>

      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">

          <li class="nav-item">
            <a href="{{ url('/admin') }}" class="nav-link {{ Request::segment(2) == ""?"active":"" }}">
              <i class="nav-icon fas fa-tachometer-alt"></i>
              <p>
                Главная
                {{-- <span class="badge badge-info right">2</span> --}}
              </p>
            </a>
          </li>

          @if(user_can('list_projects'))

            <li class="nav-item">
                <a href="{{ url('/admin/projects') }}" class="nav-link {{ Request::segment(2) == "projects"?"active":"" }}">
                    <i class="nav-icon fas fa-list-alt"></i> <p>Проекты</p>
                </a>
            </li>
          @endif

          @if(user_can('list_tasks'))
            <li class="nav-item has-treeview {{ Request::segment(2) == 'tasks' || strpos(Request::segment(2), "tasks")!==FALSE? 'menu-open':'' }}">
              <a href="#" class="nav-link {{ Request::segment(2) == 'tasks' || strpos(Request::segment(2), "tasks")!==FALSE? 'active':'' }}">
                <i class="nav-icon fa fa-tasks"></i>
                <p>Задания <i class="right fas fa-angle-left"></i> </p>
              </a>
              <ul class="nav nav-treeview">

                @if(user_can('create_task'))
                  <li class="nav-item">
                    <a href="{{ url('/admin/tasks/create') }}" class="nav-link" title="Добавить">
                      Добавить
                    </a>
                  </li>
                @endif

                <li class="nav-item">
                  <a class="nav-link {{ Request::segment(3) == ""?"active":"" }}" href="{{ url('/admin/tasks') }}">
                    В работе 
                    @if(count(getUnreadChatMessages()) > 0)
                      <span class="badge badge-warning right">{{ count(getUnreadChatMessages()) }}</span>
                    @endif
                  </a>
                </li>
                <li class="nav-item">
                  <a class="nav-link {{ Request::segment(3) == "4"?"active":"" }}" href="{{ url('/admin/tasks/4/status') }}">
                    Завершен
                  </a>
                </li>
                <li class="nav-item">
                  <a class="nav-link {{ Request::segment(3) == "3"?"active":"" }}" href="{{ url('/admin/tasks/3/status') }}">
                    Отменен
                  </a>
                </li>
                <li class="nav-item">
                  <a class="nav-link {{ Request::segment(3) == "2"?"active":"" }}" href="{{ url('/admin/tasks/2/status') }}">
                    Архив
                  </a>
                </li>

                

              </ul>
            </li>

          @endif

          @if(user_can('show_calendar'))
            <li class="nav-item">
              <a href="{{ url('/admin/calendar') }}" class="nav-link {{ Request::segment(2) == "calendar"?"active":"" }}">
                  <i class="nav-icon fas fa-calendar"></i> <p>Календарь</p>
              </a>
            </li>
          @endif

          @if(user_can('list_emails') || user_can('compose_email'))
            <li class="nav-item has-treeview {{ Request::segment(2) == 'mailbox' || strpos(Request::segment(2), "mailbox")!==FALSE? 'menu-open':'' }}">
              <a href="#" class="nav-link {{ Request::segment(2) == 'mailbox' || strpos(Request::segment(2), "mailbox")!==FALSE? 'active':'' }}">
                <i class="nav-icon fas fa-users"></i>
                <p>Сообщения <i class="right fas fa-angle-left"></i> </p>
              </a>
              <ul class="nav nav-treeview">
                @if(user_can('list_emails'))
                  <li class="nav-item">
                    <a class="nav-link {{ Request::segment(2) == "mailbox"?"active":"" }}" href="{{ url('/admin/mailbox') }}">
                      Входящие
                      @if(count(getUnreadMessages()) > 0)
                        <span class="badge badge-info right">
                            {{count(getUnreadMessages())}}
                        </span>
                      @endif
                    </a>
                  </li>
                @endif

                @if(user_can('compose_email'))
                  <li class="nav-item">
                    <a class="nav-link {{ Request::segment(2) == "mailbox-create"?"active":"" }}" href="{{ url('/admin/mailbox-create') }}">
                      <i class="fa fa-user-o"></i>
                      Написать
                    </a>
                  </li>
                @endif

              </ul>
            </li>

          @endif

          
          <li class="nav-item has-treeview {{ in_array(Request::segment(2), ['users', 'permissions', 'roles'])?"menu-open":"" }}">
            <a href="#" class="nav-link {{ in_array(Request::segment(2), ['users', 'permissions', 'roles'])?"active":"" }}">
              <i class="nav-icon fas fa-users"></i>
              <p>Пользователи <i class="right fas fa-angle-left"></i> </p>
            </a>
            <ul class="nav nav-treeview">
              @if(user_can('list_documents'))
              <li class="nav-item">
                <a class="nav-link {{ Request::segment(2) == "users"?"active":"" }}" href="{{ url('/admin/users') }}"><i class="fa fa-user-o"></i> Пользователи</a>
              </li>
              @endif
              @if(\Auth::user()->is_admin == 1)
              <li class="nav-item">
                <a class="nav-link {{ Request::segment(2) == "permissions"?"active":"" }}" href="{{ url('/admin/permissions') }}"><i class="fa fa-user-o"></i> Права</a>
              </li>

              <li class="nav-item">
                <a class="nav-link {{ Request::segment(2) == "roles"?"active":"" }}" href="{{ url('/admin/roles') }}"><i class="fa fa-user-o"></i> Роли</a>
              </li>
              @endif
            </ul>
          </li>
          

          @if(user_can('list_documents'))
            <li class="nav-item">
              <a class="nav-link {{ Request::segment(2) == "documents"?"active":"" }}" href="{{ url('/admin/documents') }}">
                <i class="nav-icon fas fa-copy"></i>
                <p>Документы</p>
              </a>
            </li>
          @endif

      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>