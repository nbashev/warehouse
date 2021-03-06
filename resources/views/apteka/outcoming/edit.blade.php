<div class="modal-dialog" role="document">
  <div class="modal-content">
    <div class="modal-header">
      <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
      <h4 class="modal-title" id="productSelectLabel">@lang('apteka.products')</h4>
    </div>
    <div class="modal-body">
      <table class="table table-hover">
        <thead>
          <tr>
            <th>@lang('apteka.title')</th>
            <th>@lang('apteka.measure')</th>
            <th>@lang('apteka.cert')</th>
            <th>@lang('apteka.serial')</th>
            <th>@lang('apteka.expire')</th>
            <th>@lang('apteka.quantity')</th>
            <th>@lang('apteka.averageprice')</th>
          </tr>
        </thead>
        <tr>
          <td>{{$outcoming->product->title}}</td>
          <td>{{$outcoming->product->measure}}</td>
          <td>{{$outcoming->incoming->cert}}</td>
          <td>{{$outcoming->incoming->serial}}</td>
          <td>{{$outcoming->incoming->expire}}</td>
          <td>{{$outcoming->product->quantity}}</td>
        </tr>
      </table>

      <div class="row">
        <div class="modal-header">
          <h4 class="modal-title" id="productSelectLabel">@lang('apteka.outcoming')</h4>
        </div>
        <div class="modal-body">

          <div class="col-md-6">

            {!! Form::open(['route' => ['apteka.outcoming.update', $outcoming->id], 'method' => 'PUT', 'class' => 'form-horizontal', 'id' => 'outcoming']) !!}

            <div class="form-group">
              {!! Form::label('client_id', Lang::get('apteka.client'), ['class' => 'col-md-6 control-label']) !!}
              <div class="col-md-6">
                {!! Form::hidden('client_id', $outcoming->client->id, ['class' => 'form-control']) !!}
                <span id="client_name">{{$outcoming->client->title}}</span>&nbsp;
                <button type="button" class="btn btn-sm" data-toggle="collapse" data-target="#clientSelect" aria-expanded="false" aria-controls="clientSelect">@lang('apteka.select')</button>
              </div>
            </div>

            {!! Form::hidden('product_id', $outcoming->product->id, ['class' => 'form-control']) !!}
            {!! Form::hidden('incoming_id', $outcoming->incoming_id, ['class' => 'form-control']) !!}

            <div class="form-group">
              {!! Form::label('count', Lang::get('apteka.count'), ['class' => 'col-md-6 control-label']) !!}
              <div class="col-md-6">
                {!! Form::text('count', $outcoming->count, ['class' => 'form-control', 'onchange' => "this.value = this.value.replace(/,/g, '.')"]) !!}
              </div>
            </div>

            <div class="form-group">
              {!! Form::label('date', Lang::get('apteka.date'), ['class' => 'col-md-6 control-label']) !!}
              <div class="col-md-6">
                {!! Form::text('date', $outcoming->date, ['class' => 'form-control']) !!}
              </div>
            </div>

            <div class="form-group">
              {!! Form::label('description', Lang::get('apteka.description'), ['class' => 'col-md-6 control-label']) !!}
              <div class="col-md-6">
                {!! Form::text('description', $outcoming->description, ['class' => 'form-control']) !!}
              </div>
            </div>

            <div class="form-group">
              {!! Form::submit(Lang::get('apteka.save')) !!}
            </div>
            {!! Form::close() !!}

          </div>
          <div class="col-md-6">

            {!! Form::open(['route' => ['apteka.client.store'], 'method' => 'POST', 'class' => 'collapse form-inline', 'id' => 'clientSelect']) !!}
            <h4>@lang('apteka.selectclient')</h4>

            <ul id="clientsList">
              @foreach($clients as $client)
              <li><a href="#" data-id="{{$client->id}}">{{$client->title}}</a></li>
              @endforeach
            </ul>

            <h4>@lang('apteka.addnew')</h4>
            <div class="form-group">
              {!! Form::label('title', Lang::get('apteka.title'), ['class' => 'control-label']) !!}
              {!! Form::text('title', '', ['class' => 'form-control', 'autofocus']) !!}
            </div>

            <div class="form-group">
              {!! Form::submit(Lang::get('apteka.save')) !!}
            </div>
            {!! Form::close() !!}

          </div>
        </div>
      </div><!-- row -->
    </div>
  </div>
</div>



<style type="text/css">
  #clientsList {
    max-height: 600px;
    overflow-y: auto;
  }
</style>

<script type="text/javascript">
$(function () {
  $.datepicker.setDefaults($.datepicker.regional[ "uk" ]);
  $( "#date" ).datepicker({dateFormat: "yy-mm-dd"});

  $('#clientsList').on('click' , 'a', function(e){
    e.preventDefault();
    var id = $(this).data('id');
    var title = $(this).text();
    $('#client_name').text(title);
    $('#client_id').val(id);
    $('#clientSelect').removeClass('in');
  });

  var formAddItem = $("#clientSelect");
  var listItems = $("#clientsList");

  formAddItem.submit(function(e) {
    $.ajax({
      type: "POST",
      url: $(this).attr("action"),
      data: $(this).serialize(),
      dataType: 'json',
      success: function(data)
      {
        listItems.append('<li><a href="#" data-id="'+data.id+'">'+data.title+'</a></li>');
        $('#client_name').text(data.title);
        $('#client_id').val(data.id);
        $('#clientSelect').removeClass('in');
      },
      error: function(data)
      {
        formAddItem.append("<p>"+$.parseJSON(data.responseText).title[0]);
      }
    });
    e.preventDefault();
  });

});
</script>
