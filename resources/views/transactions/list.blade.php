@extends('layouts.layout')

@section('content')
    <section class="content-header">
      <h1>
        Transações
      </h1>
      <ol class="breadcrumb">
        <li><a href="{{url('')}}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
        <li class="active">Transações</li>
      </ol>
    </section>

    <!-- Main content -->
  <section class="content">
    @php
    $year = (int) date('Y');
    $monthCurrent = (int) date('m');
    $next = $year + 5;
    @endphp
    <div class="row">
      <div class="col-md-6 col-xs-12">
        <div class="box box-info">
          <div class="box-header with-border">
            <h3 class="box-title">Filtro</h3>
          </div>
          @php
          $startYear = 2018;
          @endphp
          <form class="form-horizontal">
            <div class="box-body">
              <div class="col-md-4">
                <div class="form-group">
                  <label for="month" class="control-label">Mês</label>
                  <select name="search_month" id="month" class="form-control">
                    <option value="">Todos</option>
                    @foreach ($months as $key=>$month)
                    <option value="{{$key}}" @if($search_month==$key) selected @endif>{{$month}}</option>
                    @endforeach
                  </select>
                </div>
              </div>
              <div class="col-md-4">
                <div class="form-group">
                  <label for="month" class="control-label">Ano</label>
                  <select name="search_year" id="year" class="form-control">
                    <option value="">Todos</option>
                    @for ($i = $startYear; $i <= $next; $i++) <option value="{{$i}}" @if($search_year==$i) selected @endif>{{$i}}
                      </option>
                      @endfor
                  </select>
                </div>
              </div>
              <div class="col-md-4">
                <div class="form-group">
                  <label for="search_is_verified" class="control-label">Verificados</label>
                  <select name="search_is_verified" id="search_is_verified" class="form-control">
                    <option value="">Todos</option>
                    <option value="1" @if($search_is_verified=='1' ) selected @endif>Sim</option>
                    <option value="0" @if($search_is_verified=='0' ) selected @endif>Não</option>
                  </select>
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group">
                  <label for="search_type" class="control-label">Tipo</label>
                  <select name="search_type" id="search_type" class="form-control">
                    <option value="">Todos</option>
                    <option value="c" @if($search_type=='c' ) selected @endif>Credito</option>
                    <option value="d" @if($search_type=='d' ) selected @endif>Debito</option>
                  </select>
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group">
                  <label for="search_category_id" class="control-label">Categoria</label>
                  <select name="search_category_id" id="search_category_id" class="form-control">
                    <option value="">Todos</option>
                    @foreach($categories as $category)
                    <option value="{{$category['id']}}" @if($search_category_id==$category['id']) selected @endif>
                      {{$category['Title']}} - ({!!$category['Type']!!})</option>
                    @endforeach
                  </select>
                </div>
              </div>
            </div>
            <div class="box-footer">
              <button type="submit" class="btn btn-info pull-right">Aplicar</button>
            </div>
          </form>
        </div>
      </div>
      <div class="col-md-6 col-xs-12">
        <div class="col-md-6 col-xs-12">
          <!-- small box -->
          <div class="small-box bg-aqua">
            <div class="inner">
              <h3>€ {{$totals['credit']}}</h3>
              <p>Total de crédito</p>
            </div>
            <div class="icon">
              <i class="ion ion-log-in"></i>
            </div>
          </div>
        </div>
        <div class="col-md-6 col-xs-12">
          <!-- small box -->
          <div class="small-box bg-red">
            <div class="inner">
              <h3>€ {{$totals['debit']}}</h3>
              <p>Total de debito</p>
            </div>
            <div class="icon">
              <i class="ion ion-log-out"></i>
            </div>
          </div>
        </div>
        <div class="col-md-12 col-xs-12">
          <!-- small box -->
          <div class="small-box @if($totals['total'] < 0) bg-red @else bg-green @endif">
            <div class="inner">
              <h3>€ {{$totals['total']}}</h3>
              <p>Total</p>
            </div>
            <div class="icon">
              <i class="ion @if($totals['total'] < 0) ion-sad @else ion-happy @endif"></i>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="row">
      <div class="col-md-4 col-xs-12">
        <div class="box box-info">
          <div class="box-header with-border">
            <h3 class="box-title">Adicionar transação</h3>
          </div>
          <form class="form-horizontal" action="{{url('transactions')}}" method="POST" autocomplete="off">
            @csrf
            <div class="box-body">
              <div class="form-group @error('title') has-error @enderror">
                <label for="title" class="col-sm-2 control-label">Titulo</label>
                <div class="col-sm-10">
                  <input type="text" name="title" class="form-control" id="title" placeholder="Jantar romantico">
                  @error('title')
                  <span class="help-block">
                    <strong>{{ $message }}</strong>
                  </span>
                  @enderror
                </div>
              </div>
              <div class="form-group @error('value') has-error @enderror">
                <label for="value" class="col-sm-2 control-label">Valor</label>
                <div class="col-sm-10">
                  <input type="text" name="value" class="form-control money" id="value" placeholder="22.00">
                  @error('value')
                  <span class="help-block">
                    <strong>{{ $message }}</strong>
                  </span>
                  @enderror
                </div>
              </div>
              <div class="form-group @error('category_id') has-error @enderror">
                <label for="CategoryId" class="col-sm-2 control-label">Categoria</label>
                <div class="col-sm-10">
                  <select name="category_id" id="CategoryId" class="form-control">
                    <option value="">Categorias</option>
                    @foreach($categories as $category)
                    <option value="{{$category['id']}}">{{$category['Title']}} - ({!!$category['Type']!!})</option>
                    @endforeach
                  </select>
                  @error('category_id')
                  <span class="help-block">
                    <strong>{{ $message }}</strong>
                  </span>
                  @enderror
                </div>
              </div>
              <div class="form-group @error('is_verified') has-error @enderror">
                <label for="isVerified" class="col-sm-2 control-label">Verificado</label>
                <div class="col-sm-10">
                  <select name="is_verified" id="isVerified" class="form-control">
                    <option value="0">Não</option>
                    <option value="1">Sim</option>
                  </select>
                  @error('category_id')
                  <span class="help-block">
                    <strong>{{ $message }}</strong>
                  </span>
                  @enderror
                </div>
              </div>
              <div class="form-group">
                <div class="col-sm-5">
                  <div class="checkbox">
                    <label>
                      <input type="checkbox" name="is_recurrent" id="isRecurrent"> <strong>É recorrente</strong>
                    </label>
                  </div>
                </div>
                <label for="period" class="col-sm-2 control-label">Periodo</label>
                <div class="col-sm-5">
                  <select name="period" id="period" class="form-control">
                    <option value="2">2 months</option>
                    <option value="3">3 months</option>
                    <option value="4">4 months</option>
                    <option value="5">5 months</option>
                    <option value="6">6 months</option>
                    <option value="7">7 months</option>
                    <option value="8">8 months</option>
                    <option value="9">9 months</option>
                    <option value="10">10 months</option>
                    <option value="11">11 months</option>
                    <option value="12">12 months</option>
                  </select>
                </div>
              </div>
              <div class="form-group">
                <label for="month" class="col-sm-2 control-label">Mês/Ano</label>
                <div class="col-sm-5">
                  <select name="month" id="month" class="form-control">
                    @foreach ($months as $key=>$month)
                    <option value="{{$key}}" @if($monthCurrent===$key) selected @endif>{{$month}}</option>
                    @endforeach
                  </select>
                </div>
                <div class="col-sm-5">
                  <select name="year" id="year" class="form-control">
                    @for ($i = $year; $i <= $next; $i++) <option value="{{$i}}">{{$i}}</option>
                      @endfor
                  </select>
                </div>
              </div>
            </div>
            <div class="box-footer">
              <button type="reset" class="btn btn-default">Limpar</button>
              <button type="submit" class="btn btn-info pull-right">Adicionar</button>
            </div>
          </form>
        </div>
      </div>
      <div class="col-md-8 col-xs-12">
        <div class="box">
          <div class="box-header">
            <h3 class="box-title">Transações</h3>
          </div>
          <!-- /.box-header -->
          <div class="box-body">
            @if(!empty($data))
            @include('includes.datatables', ['data' => $data, 'actions' => [
            'delete' => url('transactions/delete'),
            'verify' => url('transactions/verify'),
            ]
            ]
            )
            @endif
          </div>
          <!-- /.box-body -->
        </div>
      </div>
    </div>
  </section>
@endsection
