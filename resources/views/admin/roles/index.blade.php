@inject('request', 'Illuminate\Http\Request')
@extends('layouts.app')

@section('content')
    <h3 class="page-title">@lang('global.roles.title')</h3>
    @can('role_create')
    <p>
        <a href="{{ URL_ROLES_ADD }}" class="btn btn-success">@lang('global.app_add_new')</a>
        <a href="#" class="btn btn-warning" style="margin-left:5px;" data-toggle="modal" data-target="#myModal">@lang('global.app_csvImport')</a>
        @include('csvImport.modal', ['model' => 'Role'])
        
    </p>
    @endcan

    

    <div class="panel panel-default">
        <div class="panel-heading">
            @lang('global.app_list')
        </div>

        <div class="panel-body table-responsive">
            <table class="table table-bordered table-striped {{ count($roles) > 0 ? 'datatable' : '' }} @can('role_delete') dt-select @endcan">
                <thead>
                    <tr>
                        @can('role_delete')
                            <th style="text-align:center;"><input type="checkbox" id="select-all" /></th>
                        @endcan

                        <th>@lang('global.roles.fields.title')</th>
                        <th>@lang('global.roles.fields.permission')</th>
                                                <th>&nbsp;</th>

                    </tr>
                </thead>
                  @if (count($roles) > 0)  
                <tbody>
                    @if (count($roles) > 0)
                        @foreach ($roles as $role)
                            <tr data-entry-id="{{ $role->id }}">
                                @can('role_delete')
                                    <td></td>
                                @endcan

                                <td field-key='title'>{{ $role->title }}</td>
                                <td field-key='permission'>
                                    @foreach ($role->permission as $singlePermission)
                                        <span class="label label-info label-many">{{ $singlePermission->title }}</span>
                                    @endforeach
                                </td>
                                                                <td>
                                    @can('role_view')
                                    <a href="{{URL_ROLES_VIEW}}/{{$role->id}}" class="btn btn-xs btn-primary">@lang('global.app_view')</a>
                                    @endcan
                                    @can('role_edit')
                                    <a href="{{URL_ROLES_EDIT}}/{{$role->id}}" class="btn btn-xs btn-info">@lang('global.app_edit')</a>
                                    @endcan
                                    @can('role_delete')
{!! Form::open(array(
                                        'style' => 'display: inline-block;',
                                        'method' => 'DELETE',
                                        'onsubmit' => "return confirm('".trans("global.app_are_you_sure")."');",
                                        'route' => ['roles.destroy', $role->id])) !!}
                                    {!! Form::submit(trans('global.app_delete'), array('class' => 'btn btn-xs btn-danger')) !!}
                                    {!! Form::close() !!}
                                    @endcan
                                </td>

                            </tr>
                        @endforeach
                    @else
                        <tr>
                            <td colspan="7">@lang('global.app_no_entries_in_table')</td>
                        </tr>
                    @endif
                </tbody>
                 @endif
            </table>
        </div>
    </div>
@stop

@section('javascript') 
    <script>
        @can('role_delete')
            window.route_mass_crud_entries_destroy = '{{ route('roles.mass_destroy') }}';
        @endcan

    </script>
@endsection