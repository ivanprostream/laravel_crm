{{-- <div class="box box-solid">
    <div class="box-header with-border">
 
        <div class="box-tools">
            <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
            </button>
        </div>
    </div>
    <div class="box-body no-padding">
        <ul class="nav nav-pills nav-stacked">
            @foreach($folders as $folder)
                <li class="{{ Request::segment(3)=='' && $folder->title=='Inbox'?'active':(Request::segment(3) == $folder->title?'active':'') }}"><a href="{{ url('admin/mailbox/' . $folder->title) }}"><i class="{{ $folder->icon }}"></i> {{ $folder->title }}
                        @if($folder->title=='Inbox' && $unreadMessages)<span class="label label-primary pull-right">{{$unreadMessages}}</span> @endif
                     </a></li>
            @endforeach
        </ul>
    </div>

</div> --}}

<div class="card">
    <div class="card-header">
      <h3 class="card-title">Папки</h3>

      <div class="card-tools">
        <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i>
        </button>
      </div>
    </div>
    <div class="card-body p-0">
      <ul class="nav nav-pills flex-column">

        @foreach($folders as $folder)
            <li class="nav-item {{ Request::segment(3)=='' && $folder->title=='Inbox'?'active':(Request::segment(3) == $folder->title?'active':'') }}"><a class="nav-link" href="{{ url('admin/mailbox/' . $folder->title) }}"><i class="{{ $folder->icon }}"></i> {{ $folder->name }}
                    @if($folder->title=='Inbox' && $unreadMessages)<span class="badge bg-primary float-right">{{$unreadMessages}}</span> @endif
                 </a></li>
        @endforeach
      </ul>
    </div>
    <!-- /.card-body -->
    </div>