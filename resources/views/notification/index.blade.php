
@extends('layouts.master')
@section('content')
<div class="content-wrapper">
    <div class="content-header row">
        <div class="content-header-left col-md-6 col-12 mb-2">
            <h3 class="content-header-title mb-0">{{__('translation.notification')}}</h3>
            <div class="row breadcrumbs-top">
                <div class="breadcrumb-wrapper col-12">
                    {{ Breadcrumbs::render('notification') }}
                </div>
            </div>
        </div>
        <div class="content-header-right text-md-right col-md-6 col-12">
            {{-- @can('role-create') --}}
            <div class="btn-group">
                <a href="{{ route('notification.create') }}" class="btn btn-round btn-info" type="button"><i
                        class="icon-cog3"></i>
                    {{__('translation.add')}}</a>
            </div>
            {{-- @endcan --}}
        </div>
    </div>
    <div class="content-body">
        <!-- Zero configuration table -->
        <section id="configuration">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <a class="heading-elements-toggle"><i class="la la-ellipsis-v font-medium-3"></i></a>
                            <div class="heading-elements">
                                <ul class="list-inline mb-0">
                                    <li><a data-action="collapse"><i class="ft-minus"></i></a></li>
                                    <li><a data-action="reload"><i class="ft-rotate-cw"></i></a></li>
                                    <li><a data-action="expand"><i class="ft-maximize"></i></a></li>
                                    {{-- <li><a data-action="close"><i class="ft-x"></i></a></li> --}}
                                </ul>
                            </div>
                        </div>
                        <div class="card-content collapse show">
                            <div class="card-body card-dashboard">
                                @include('includes.dashboard.notifications')
                                <div class="table-responsive">
                                <table class="table table-striped table-bordered ">
                                    <thead>
                                        <tr>
                                            <th>{{__('translation.No')}}</th>
                                            <th>{{__('translation.name')}}</th>
                                            <th>{{__('translation.note')}}</th>
                                            <th>{{__('translation.type')}}</th>
                                            <th>{{__('translation.user')}}</th>
                                            <th>{{__('translation.area')}}</th>
                                            <th>{{__('translation.notify_image')}}</th>
                                            <th>{{__('translation.date')}}</th>
                                            {{-- <th>{{__('translation.')}}</th> --}}
                                            <th>{{__('translation.action')}}</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if (count($Notification) > 0 )
                                        @foreach ($Notification as $key => $notification)
                                        <tr>
                                            <td>{{ $key + 1 }}</td>
                                            <td>{{ $notification->title }}</td>
                                            <td>{{ $notification->notifcation }}</td>
                                            <td>{{ __('translation.' . $notification->type. 's') }}</td>
                                            <td> {{$notification->User->fullname ?? __('translation.to_all_user') }}</td>
                                            <td>{{ $notification->Area->name ?? ' - ' }}</td>
                                            <td><div class="text-center">
                                                @if($notification->getRawOriginal('image'))
                                                    <img src="{{$notification->image}}" width='60px' height="60px"  alt=""></div></td>
                                                @else
                                                        {{__('translation.no.image')}}
                                                @endif
                                            <td>{{ $notification->notification_date }}</td>
                                            <td>
                                                <a class="btn btn-sm btn-icon btn-success"
                                                    href="{{ route('notification.edit',$notification->id) }}">
                                                    <i class="la la-retweet"></i> </a>
                                                {!! Form::open(['id' => 'deleteform'.$key , 'method' =>
                                                'DELETE','route' => ['notification.destroy',
                                                $notification->id],'style'=>'display:inline']) !!}
                                                <button
                                                    onclick="event.preventDefault();deleteConfirmation({{$key}})"
                                                    class="btn btn-sm btn-icon btn-danger" type="submit"
                                                    value="Delete"><i class="la la-trash"></i></button>
                                                {!! Form::close() !!}
                                                {{-- @endcan --}}
                                            </td>
                                        </tr>
                                        @endforeach
                                        @else
                                        <tr class="text-center">
                                            <td colspan="10">{{__('translation.table.empty')}}</td>
                                        </tr>
                                        @endif
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <th>{{__('translation.No')}}</th>
                                            <th>{{__('translation.name')}}</th>
                                            <th>{{__('translation.note')}}</th>
                                            <th>{{__('translation.type')}}</th>
                                            <th>{{__('translation.user')}}</th>
                                            <th>{{__('translation.area')}}</th>
                                            <th>{{__('translation.notify_image')}}</th>
                                            <th>{{__('translation.date')}}</th>
                                            <th>{{__('translation.action')}}</th>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                            @if (count($Notification) > 0)
                            {{-- @dd('jksa') --}}
                                    {!! $Notification->links() !!}
                            @endif
                        </div>
                    </div>
                </div>
            </div>
            </div>
            {{-- {!! $Notification->links() !!} --}}
        </section>
        <!--/ Zero configuration table -->
    </div>
</div>
@endsection


@push('scripts')
<script type="text/javascript">
    function deleteConfirmation(iteration) {
                swal.fire({
                    title: "{{__('translation.delete') . __('translation.?') }} ",
                    text: '{{ __('translation.do_you_want_Delete_item')}}' ,
                    type: "warning",
                    showCancelButton: !0,
                    confirmButtonText:'{{ __('translation.delete')}}',
                    cancelButtonText:'{{ __('translation.cancel')}}',
                    reverseButtons: !0
                }).then(function (e) {
                    if (e.value === true) {
                        console.log('delted');
                        $('#deleteform'+iteration).submit();
                    } else {
                        e.dismiss;
                    }
                }, function (dismiss) {
                    return false;
                })
            }
</script>

@endpush
