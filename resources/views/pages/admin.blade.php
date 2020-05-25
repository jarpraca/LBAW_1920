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

            <form class="form-inline ml-3 py-2 my-lg-0">
                <label style="visibility:hidden" for="search"></label>
                <input class="form-control w-50 mr-sm-2" type="search" placeholder="Search" id="search" aria-label="Search">
                <button class="btn btn-green2 my-2 my-sm-0" type="submit">Search</button>
            </form>

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