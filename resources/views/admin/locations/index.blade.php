@extends('adminlte::page')

@section('content_header')
    <h1>Localidades</h1>
@stop

@section('content')

    <div class="col-md-12">
      <div class="box box-success">
        <div class="box-header with-border">
          <h3 class="box-title">Listagem</h3>

          <div class="box-tools pull-right">
            <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
          </div>
        </div>
        <div class="box-body">

          <table class="table">

              <tbody>
                @foreach($locations as $location)
                <tr><td><a href="{{ route('location_medias', ['id' => $location['id']]) }}">{{ $location['name'] }}</a></td></tr>
                @endforeach
              </tbody>

          </table>

        </div>
      </div>
    </div>

@stop
