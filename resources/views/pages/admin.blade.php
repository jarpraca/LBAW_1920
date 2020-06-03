@extends('layouts.app')

@section('title', 'Admin Dashboard')

@section('content')

<section class="mainBody mb-3">

    <h1 class="mt-3 mb-3 colorGreen">Admin Dashboard</h1>

    <div id="reports" class="card">
        <div class="card-header border-transparent">
            <h3 class="card-title text-dark">Report Inbox</h3>
        </div>
        <!-- /.card-header -->
        <div class="reports card-body p-0">
            @include('partials.reports')
        </div>
        <!-- /.card-footer -->
    </div>
    <!-- /.card -->
    
    <div id="users" class="card my-5">
        <div class="card-header border-transparent">
            <h3 class="card-title text-dark">Block and Delete Users</h3>
        </div>
        <!-- /.card-header -->
        <div class="users card-body p-0">
            @include('partials.blocks')
        </div>
        <!-- /.card-footer -->
    </div>
    <!-- /.card -->

</section>
@endsection