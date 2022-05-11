<!-- User Id Field -->
{{--<div class="form-group col-sm-6">--}}
{{--    {!! Form::label('user_id', 'User Id:') !!}--}}
    {!! Form::hidden('user_id', \Illuminate\Support\Facades\Auth::user()->id, ['class' => 'form-control', 'placeholder'=>'Enter user_id']) !!}
{{--</div>--}}

<!-- Name Field -->
<div class="form-group col-sm-6">
    {!! Form::label('name', 'Task Name:') !!}
    {!! Form::text('name', null, ['class' => 'form-control', 'placeholder'=>'Enter name']) !!}
</div>

<!-- Detail Field -->
<div class="form-group col-sm-6">
    {!! Form::label('detail', 'Task Detail:') !!}
    {!! Form::text('detail', null, ['class' => 'form-control', 'placeholder'=>'Enter detail']) !!}
</div>

<!-- Submit Field -->
<div class="form-group col-sm-12">
    {!! Form::submit('Save', ['class' => 'btn btn-primary']) !!}
    @if(!isset($task))
        {!! Form::submit(__('Save And Add Translations'), ['class' => 'btn btn-primary', 'name'=>'translation']) !!}
    @endif
    {!! Form::submit(__('Save And Add More'), ['class' => 'btn btn-primary', 'name'=>'continue']) !!}
    <a href="{!! route('admin.tasks.index') !!}" class="btn btn-default">Cancel</a>
</div>