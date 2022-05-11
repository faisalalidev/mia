@extends('admin.layouts.app')

@section('title')
    {{ $task->name }} <small>{{ $title }}</small>
@endsection

@section('content')
   <div class="content">
       @include('adminlte-templates::common.errors')
       <div class="box box-primary">
           <div class="box-body">
               <div class="row">
                   {!! Form::model($task, ['route' => ['admin.tasks.update', $task->id], 'method' => 'patch', 'files' => true]) !!}

                        @include('admin.tasks.fields')

                   {!! Form::close() !!}
               </div>
           </div>
       </div>
   </div>
@endsection