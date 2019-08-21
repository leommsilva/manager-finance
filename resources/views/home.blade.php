@extends('layouts.layout')

@section('content')

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
        <div class="col-xs-12">
          <div class="box box-info">
            <div class="box-header with-border">
              <h3 class="box-title">Filter by year</h3>
            </div>
            @php
              $year = (int) date('Y');
              $next = $year + 5;
              $startYear = 2018;
            @endphp
            <form class="form-horizontal">
              @csrf
              <div class="box-body">
                <div class="form-group">
                  <label for="month" class="col-sm-2 control-label">Year</label>
                  <div class="col-sm-2">
                    <select name="year" id="year" class="form-control">
                      @for ($i = $startYear; $i <= $next; $i++) 
                        <option value="{{$i}}" @if($i === $yearSelected) selected @endif>{{$i}}</option>
                      @endfor
                    </select>
                  </div>
                </div>
                <div class="box-footer">
                  <button type="submit" class="btn btn-info pull-right">Apply</button>
                </div>
            </form>
          </div>
        </div>

        <div class="col-md-6 col-xs-12">
          <input type="hidden" id="chartCredit" value="{{json_encode($dataChartAll['credit'])}}">
          <input type="hidden" id="chartDebit" value="{{json_encode($dataChartAll['debit'])}}">
          <div class="box box-success">
            <div class="box-header with-border">
              <h3 class="box-title">Gasto x Ganho (Todos)</h3> <small>(De acordo com o ano selecionado.)</small>
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
              <h3 class="box-title">Gasto x Ganho (Apenas verificados)</h3> <small>(De acordo com o ano selecionado.)</small>
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

