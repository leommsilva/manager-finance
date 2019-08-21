@extends('layouts.layout')

@section('content')
    <section class="content-header">
      <h1>
        Transactions
      </h1>
      <ol class="breadcrumb">
        <li><a href="{{url('')}}"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Transactions</li>
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
        <div class="col-xs-12">
          <div class="box box-info">
            <div class="box-header with-border">
              <h3 class="box-title">Filter by month/year</h3>
            </div>
            @php
            $startYear = 2018;
            @endphp
            <form class="form-horizontal">
              <div class="box-body">
                <div class="form-group">
                  <label for="month" class="col-sm-2 control-label">Month/Year</label>
                  <div class="col-sm-2">
                    <select name="search_month" id="month" class="form-control">
                      <option value="" >All</option>
                      @foreach ($months as $key=>$month)
                      <option value="{{$key}}" @if($search_month == $key) selected @endif>{{$month}}</option>
                      @endforeach
                    </select>
                  </div>
                  <div class="col-sm-2">
                    <select name="search_year" id="year" class="form-control">
                      <option value="">All</option>
                      @for ($i = $startYear; $i <= $next; $i++) 
                        <option value="{{$i}}" @if($search_year == $i) selected @endif>{{$i}}</option>
                      @endfor
                    </select>
                  </div>
                  <label for="search_is_verified" class="col-sm-2 control-label">Verified</label>
                  <div class="col-sm-2">
                    <select name="search_is_verified" id="search_is_verified" class="form-control">
                      <option value="">All</option>
                      <option value="1" @if($search_is_verified == '1') selected @endif>Yes</option>
                      <option value="0" @if($search_is_verified == '0') selected @endif>No</option>
                    </select>
                  </div>
                </div>
                <div class="form-group">
                  <label for="search_type" class="col-sm-2 control-label">Type</label>
                  <div class="col-sm-2">
                    <select name="search_type" id="search_type" class="form-control">
                      <option value="">All</option>
                      <option value="c" @if($search_type == 'c') selected @endif>Credit</option>
                      <option value="d" @if($search_type == 'd') selected @endif>Debit</option>
                    </select>
                  </div>
                </div>
                <div class="box-footer">
                  <button type="submit" class="btn btn-info pull-right">Apply</button>
                </div>
            </form>
          </div>
        </div>

        <div class="col-md-4">
          <div class="box box-info">
            <div class="box-header with-border">
              <h3 class="box-title">Add transaction</h3>
            </div>
            <form class="form-horizontal" action="{{url('transactions')}}" method="POST">
              @csrf
              <div class="box-body">
                <div class="form-group @error('title') has-error @enderror">
                  <label for="title" class="col-sm-2 control-label">Title</label>
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
                  <label for="value" class="col-sm-2 control-label">Value</label>
                  <div class="col-sm-10">
                    <input type="number" name="value" class="form-control" id="value" placeholder="22.00">
                    @error('value')
                      <span class="help-block">
                        <strong>{{ $message }}</strong>
                      </span>
                    @enderror
                  </div>
                </div>
                <div class="form-group @error('category_id') has-error @enderror">
                  <label for="CategoryId" class="col-sm-2 control-label">Category</label>
                  <div class="col-sm-10">
                    <select name="category_id" id="CategoryId" class="form-control">
                      <option value="">Categories</option>
                      @foreach($categories as $category)
                        <option value="{{$category['id']}}">{{$category['Title']}}</option>
                      @endforeach
                    </select>
                    @error('category_id')
                      <span class="help-block">
                        <strong>{{ $message }}</strong>
                      </span>
                    @enderror
                  </div>
                </div>
                <div class="checkbox">
                  <label>
                   <input type="checkbox" name="is_recurrent" id="isRecurrent"> <strong>Is recurrent</strong> <small>(For 12 months)</small>
                  </label>
                </div>
                <br>
                <div class="form-group">
                  <label for="month" class="col-sm-2 control-label">Month/Year</label>
                  <div class="col-sm-5">
                    <select name="month" id="month" class="form-control">
                      @foreach ($months as $key=>$month)
                        <option value="{{$key}}" @if($monthCurrent === $key) selected @endif>{{$month}}</option>
                      @endforeach
                    </select>
                  </div>
                  <div class="col-sm-5">
                    <select name="year" id="year" class="form-control">
                      @for ($i = $year; $i <= $next; $i++) 
                        <option value="{{$i}}">{{$i}}</option>
                      @endfor
                    </select>
                  </div>
                </div>
              </div>
              <div class="box-footer">
                <button type="submit" class="btn btn-default">Reset</button>
                <button type="submit" class="btn btn-info pull-right">Save</button>
              </div>
            </form>
          </div>
        </div>
        <div class="col-md-8">
            <div class="box">
                <div class="box-header">
                  <h3 class="box-title">Transactions</h3>
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                  @if(!empty($data))
                    @include('includes.datatables', ['data' => $data, 'actions' => ['delete' => url('transactions/delete')]])
                  @endif
                </div>
                <!-- /.box-body -->
            </div>
        </div>
      </div>
    </section>
@endsection
