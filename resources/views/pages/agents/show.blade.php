@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-lg12 col-md-12 col-sm-12 col-xs-12 margin-top-70">
                <h2>{{ ucwords($agent->name) }}<span class="small pull-right">{{ $today }} | {{ $currenttime }}</span></h2>
                <p class="text-muted">
                    Posted by&nbsp;{{ ucwords($agent->user->name) }} | {{ $agent->created_at->format('h:i a') }} | {{ $agent->created_at->formatLocalized('%a %d %b %y') }}
                </p>
                <ol class="breadcrumb">
                    <li><a href="{{ url('agents') }}">Agents</a></li>
                    <li><a href="">{{ ucwords($agent->slug) }}</a></li>
                </ol>
            </div>
        </div>
        <div class="row">
            <div class="col-lg12 col-md-12 col-sm-12 col-xs-12">
                <div class="pull-right">
                    <a href="#createemployees" class="btn btn-sm btn-green" data-toggle="modal"> <i class="fa fa-plus"></i>&nbsp;New Employee</a>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg12 col-md-12 col-sm-12 col-xs-12">
                @if(count($employees))
                    <div class="table-responsive">
                        <table class="breadcrumb table table-hover table-condensed">
                            <thead>
                            <tr class="text-capitalize roboto">
                                <th>Name</th>
                                <th>Title</th>
                                <th>Email</th>
                                <th>Created at</th>
                                <th>Updated at</th>
                                <th>Options</th>
                            </tr>
                            </thead>
                            @foreach($employees as $employee)
                                <tbody>
                                <tr>
                                    <td>{{ $employee->name }}</td>
                                    <td>{{ $employee->title }}</td>
                                    <td>{{ $employee->email }}</td>
                                    <td>{{ $agent->created_at->diffForHumans() }}</td>
                                    <td>{{ $agent->updated_at->diffForHumans() }}</td>
                                    <td class="col-sm-3">
                                        <ul class="list-inline col-sm-12" >
                                            <li class="col-sm-3">
                                                {!! Form::open(array('method' => 'POST', 'action' => array('EmployeeController@edit', $agent->slug, $employee->slug), 'class' => 'form-horizontal')) !!}
                                                @include('partials.edit.employees', ['submitTextButton' => 'Edit'])
                                                {!! Form::close() !!}
                                            </li>
                                            <li class="col-sm-5">
                                                {!! Form::open(array('method' => 'DELETE', 'action' => array('EmployeeController@delete', $agent->slug, $employee->slug), 'class' => 'form-horizontal')) !!}
                                                @include('partials.delete.delete', ['submitTextButton' => 'Delete'])
                                                {!! Form::close() !!}
                                            </li>
                                        </ul>
                                    </td>
                                </tr>
                                </tbody>
                            @endforeach
                        </table>
                    </div>
                @else
                    <p>Sorry no employees found, begin by creating one.</p>
                @endif
            </div>
        </div>
    </div>
    @include('modals.create.employees', ['submitTextButton' => 'ADD'])
    @if(count($employees))
        @include('modals.edit.employees', ['submitTextButton' => 'Update'])
    @endif
@endsection
