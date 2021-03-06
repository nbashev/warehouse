@extends('apteka.layouts.default')

@section('content')
<h1 class="page-header">@lang('apteka.invoice')</h1>

{!! Form::open(['route' => ['apteka.invoice.store'], 'method' => 'POST', 'class' => 'form-horizontal']) !!}
  <div class="form-group">
    {!! Form::label('title', Lang::get('apteka.invoice_title'), ['class' => 'col-md-2 control-label']) !!}
    <div class="col-md-10">
      {!! Form::text('title', '', ['class' => 'form-control', 'autofocus']) !!}
    </div>
  </div>

  <div class="form-group">
    {!! Form::label('supplier_id', Lang::get('apteka.supplier'), ['class' => 'col-md-2 control-label']) !!}
    <div class="col-md-10">
    {!! Form::hidden('supplier_id', '', ['class' => 'form-control']) !!}
    <span id="supplier_name"></span>&nbsp;
    <button type="button" class="btn btn-sm" data-toggle="modal" data-target="#supplierSelect">@lang('apteka.select')</button>
    </div>
  </div>

  <div class="form-group">
    {!! Form::label('price', Lang::get('apteka.price'), ['class' => 'col-md-2 control-label']) !!}
    <div class="col-md-10">
      {!! Form::text('price', '', ['class' => 'form-control', 'onchange' => "this.value = this.value.replace(/,/g, '.')"]) !!}
    </div>
  </div>

  <div class="form-group">
    {!! Form::label('date', Lang::get('apteka.date'), ['class' => 'col-md-2 control-label']) !!}
    <div class="col-md-10">
      {!! Form::text('date', '', ['class' => 'form-control', 'id' => 'datepicker']) !!}
    </div>
  </div>

  <div class="form-group">
    {!! Form::submit(Lang::get('apteka.save')) !!}
  </div>
{!! Form::close() !!}


<!-- Modal -->
<div class="modal fade" id="supplierSelect" tabindex="-1" role="dialog" aria-labelledby="supplierSelectLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="supplierSelectLabel">@lang('apteka.suppliers')</h4>
      </div>
      <div class="modal-body">
        <ul id="suppliersList">
        @foreach($suppliers as $supplier)
          <li><a href="#" data-id="{{$supplier->id}}">{{$supplier->title}}</a></li>
        @endforeach
        </ul>
      </div>
      <div class="modal-footer">

        <button class="btn btn-sm left" type="button" data-toggle="collapse" data-target="#addProduct" aria-expanded="false" aria-controls="addProduct">@lang('apteka.add')</button>
          {!! Form::open(['route' => ['apteka.supplier.store'], 'method' => 'POST', 'class' => 'collapse form-inline', 'id' => 'addProduct']) !!}

            <div class="form-group">
              {!! Form::label('title', Lang::get('apteka.title'), ['class' => 'control-label']) !!}
              {!! Form::text('title', '', ['class' => 'form-control', 'autofocus']) !!}
            </div>

            <div class="form-group">
              {!! Form::submit(Lang::get('apteka.save')) !!}
            </div>
          {!! Form::close() !!}

        <button type="button" class="btn btn-primary" data-dismiss="modal">@lang('apteka.select')</button>
      </div>
    </div>
  </div>
</div>
@endsection

@section('styles')
<style type="text/css">
  .col-md-10 input {max-width: 200px;}
  #suppliersList {
    max-height: 600px;
    overflow-y: auto;
  }
  button.left, #addProduct {float: left;}
</style>
@endsection

@section('scripts')
<script type="text/javascript">
$(function () {
  $.datepicker.setDefaults($.datepicker.regional[ "uk" ]);
  $( "#datepicker" ).datepicker({
      dateFormat: "yy-mm-dd",
    });

  $('#suppliersList').on('click' , 'a', function(e){
    e.preventDefault();
    var id = $(this).data('id');
    var title = $(this).text();
    $('#supplier_name').text(title);
    $('#supplier_id').val(id);
    $('#supplierSelect').modal('hide');
  });

  var formAddProduct = $("#addProduct");
  formAddProduct.submit(function(e) {
    $.ajax({
      type: "POST",
      url: "{{route('apteka.supplier.store')}}",
      data: $(this).serialize(),
      dataType: 'json',
      success: function(data)
      {
        $('#suppliersList').append('<li><a href="#" data-id="'+data.id+'">'+data.title+'</a></li>');
        $('#supplier_name').text(data.title);
        $('#supplier_id').val(data.id);
        $('#supplierSelect').modal('hide');
      },
      error: function(data)
      {
        formAddProduct.append("<p>"+$.parseJSON(data.responseText).title[0]);
      }
    });
    e.preventDefault();
  });

});
</script>
@endsection