@extends('admin.layout.it-connect-master')

@section('page-js')
    {{-- Deat Piker --}}
    @include('admin.layout.datePiker.datePiker')
@endsection

@section('content')

<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title" id="bordered-layout-colored-controls">SMS Report Generate</h4>

            </div>
            <div class="card-body">

                <form action="{{ route('it.connect.admin.view.report') }}" method="post" >
                   @csrf

                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Start Date</label>
                                <div class='input-group'>
                                    <input type='text' class="form-control" id="datepicker" name="date"
                                        placeholder="Enter Report Date" required="required" />
                                    <div class="input-group-append">
                                        <span class="input-group-text">
                                            <span class="fa fa-calendar-o"></span>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Operation</label>
                                <select class="form-control" name="opCode" required="required" >
                                    <option value="" >Select One Operation</option>
                                    @foreach ($opData as $op)
                                <option value="{{ $op->code }}" >{{ $op->name  }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>SMS Type</label>
                                <select class="form-control" name="type" required="required" >
                                    <option value="" selected>Choose SMS Type</option>
                                    <option value="saleOrder" >Sales Order</option>
                                    <option value="salePament" >Sales Payment</option>
                                </select>
                            </div>
                        </div>
                    </div>

                 

                    <div class="form-actions right">
                        <button type="button" class="btn btn-raised btn-warning mr-1" onClick="history.go(-1); return false;"><i class="ft-x"></i> Cancel</button>
                        <button id="btnSubmit" type="submit" name="submit" class="btn btn-raised btn-primary"><i
                                class="fa fa-check-square-o"></i> View Report</button>
                    </div>


                </form>


            </div>
        </div>
    </div>
</div>
    
@endsection