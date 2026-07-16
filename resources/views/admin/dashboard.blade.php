@extends('layout.default')
@section('content')
<div class="container">
    <div class="card">
        <div class="card-header bg-transparent  ">
            <h5 class="card-title">Dashboard</h5>
        </div>
        <div class="card-body">
            <p>Welcome to the Admin Dashboard!</p>
        </div>
    </div>
</div>
@include('layout.include.footer')
@endsection
@section('script')
@include("layout.datatable")
<script></script>
@endsection
