@extends('layouts.app')

@section('htmlheader_title')
	User
@endsection


@section('main-content')
	<div class="container spark-screen">
		<form class="form-horizontal">
  <fieldset>
    <legend></legend>
<div class="row">
           <div class="col-md-6 col-xs-12">
         

               @if($isEdit)
                    {!! Form::model($product, ['route'=>['admin.products.update',$product->ext_id], 'method'=>'PUT', 'role'=>'form', 'name' => 'productFrm', 'id' => 'productFrm','class' => 'form-horizontal']) !!}
                @else      
                    {!! Form::model(Request::all(),['route'=>['admin.products.store'], 'method'=>'POST', 'name'=>'productFrm', 'id'=> 'productFrm', 'role'=>'form','class' => 'form-horizontal']) !!}
                @endif
  
                    <fieldset>
                      {!! csrf_field() !!}
                    
                        <div class="form-group">
                        <label for="model" class="col-lg-2 control-label">{{ trans('message.role') }}</label>
                        <div class="col-lg-10">
                         {!! Form::select('roleList', $roles, isset($role) && $role->id ? $role->id  : old('roleList'), ['class' => 'form-control']); !!}
                          
                        </div>
                      </div>
                      <div class="form-group">
                         
                        <label for="inputModel" class="col-lg-2 control-label">{{ trans('message.name') }}</label>
                        <div class="col-lg-10">
                                      {{ Form::text('name', isset($user->name) ? $user->model : old('model'), array('class' => 'form-control', 'id' => 'name','placeholder'=>trans('message.name')  )) }}

                        </div>
                      </div>
                      <div class="form-group">
                         
                        <label for="inputLine" class="col-lg-2 control-label">{{ trans('message.line') }}</label>
                        <div class="col-lg-10">
                                      {{ Form::text('line', isset($product->line) ? $product->line : old('line'), array('class' => 'form-control', 'id' => 'line','placeholder'=>trans('message.model')  )) }}

                        </div>
                      </div>

                      <div class="form-group">
                         
                        <label for="inputTop" class="col-lg-2 control-label">{{ trans('message.top') }}</label>
                        <div class="col-lg-10">
                                      {{ Form::text('top', isset($product->top) ? $product->top : old('top'), array('class' => 'form-control', 'id' => 'top','placeholder'=>trans('message.top')  )) }}

                        </div>
                      </div>
                     
                     
                      <div class="form-group">
                        <div class="col-lg-10 col-lg-offset-2">
                          <button type="reset" class="btn btn-default">{{ trans('message.cancel') }}</button>
                          <button type="submit" id="btnSave" class="btn btn-primary">{{ trans('message.save') }}</button>
                        </div>
                      </div>
                    </fieldset>
              {!! Form::close() !!}
      
          </div>
          </div>
  
    
  </fieldset>

	</div>

<script type="text/javascript">

	
</script>
@endsection
