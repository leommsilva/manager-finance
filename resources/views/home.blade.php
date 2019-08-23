@extends('layouts.layout')

@section('content')
  @php
  $year = (int) date('Y');
  $next = $year + 5;
  $startYear = 2018;
  $monthCurrent = (int) date('m');
  @endphp
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Dashboard
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Dashboard</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="row">
          <div class="col-md-6 col-xs-12">
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
                  <div class="form-group">
                    <div class="col-sm-5">
                      <div class="checkbox">
                        <label>
                          <input type="checkbox" name="is_recurrent" id="isRecurrent"> <strong>É recorrente ?</strong>
                        </label>
                      </div>
                    </div>
                    <label for="period" class="col-sm-2 control-label">Periodo recorrente</label>
                    <div class="col-sm-5">
                      <select name="period" id="period" class="form-control">
                        <option value="2">2 meses</option>
                        <option value="3">3 meses</option>
                        <option value="4">4 meses</option>
                        <option value="5">5 meses</option>
                        <option value="6">6 meses</option>
                        <option value="7">7 meses</option>
                        <option value="8">8 meses</option>
                        <option value="9">9 meses</option>
                        <option value="10">10 meses</option>
                        <option value="11">11 meses</option>
                        <option value="12">12 meses</option>
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
                  <button type="reset" class="btn btn-default">Reset</button>
                  <button type="submit" class="btn btn-info pull-right">Save</button>
                </div>
              </form>
            </div>
          </div>
          <div class="col-md-6 col-xs-12">
            @php
              $last = $monthCurrent-1;
              $next = $monthCurrent+1;
              $lastMonth = ($monthCurrent == 1) ? 12 : $last;
              $nextMonth = ($monthCurrent == 12) ? 1 : $next;
              // dd($donutDataMonthLast,$donutDataMonth,$donutDataMonthNext)
            @endphp
            <input type="hidden" id="donutDataMonthLast" value="{{json_encode($donutDataMonthLast)}}">
            <input type="hidden" id="donutDataMonth" value="{{json_encode($donutDataMonth)}}">
            <input type="hidden" id="donutDataMonthNext" value="{{json_encode($donutDataMonthNext)}}">
            <div class="box box-primary">
              <div class="box-header with-border">
                <i class="fa fa-bar-chart-o"></i>
            
                <h3 class="box-title">Gastos Mensais</h3>
              </div>
              <div class="box-body">
                  <div class="col-md-4">
                    {{$months[$lastMonth]}}
                    <div id="donut-chart-last" style="height: 200px;"></div>
                  </div>
                  <div class="col-md-4">
                    {{$months[$monthCurrent]}}
                    <div id="donut-chart" style="height: 200px;"></div>
                  </div>
                  <div class="col-md-4">
                    {{$months[$nextMonth]}}
                    <div id="donut-chart-next" style="height: 200px;"></div>
                  </div>
              </div>
              <!-- /.box-body-->
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-md-6 col-xs-12">
            <input type="hidden" id="chartCredit" value="{{json_encode($dataChartAll['credit'])}}">
            <input type="hidden" id="chartDebit" value="{{json_encode($dataChartAll['debit'])}}">
            <div class="box box-success">
              <div class="box-header with-border">
                <h3 class="box-title">Relatorio anual ( Todos )</h3> <small>(Do ano atual.)</small>
              </div>
              <div class="box-body">
                <div class="chart">
                  <canvas id="barChart" style="height: 375px; width: 766px;" height="413" width="1378"></canvas>
                </div>
              </div>
              <!-- /.box-body -->
            </div>
          </div>
          <div class="col-md-6 col-xs-12">
            <input type="hidden" id="chartCreditVerify" value="{{json_encode($dataChartVerified['credit'])}}">
            <input type="hidden" id="chartDebitVerify" value="{{json_encode($dataChartVerified['debit'])}}">
            <div class="box box-success">
              <div class="box-header with-border">
                <h3 class="box-title">Relatorio anual ( Apenas verificados )</h3> <small>(Do ano atual.)</small>
              </div>
              <div class="box-body">
                <div class="chart">
                  <canvas id="barChartVerify" style="height: 375px; width: 766px;" height="413" width="1378"></canvas>
                </div>
              </div>
              <!-- /.box-body -->
            </div>
          </div>
      </div>
    </section>
@endsection

