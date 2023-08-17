@extends('errors::minimal')

@section('title', __('Page Expired'))
@section('code', '419')
@section('message')
    <h3> page has expired Reload page </h3>
    <button onclick="reloadPage()"> Reload </button>
    <script>
        function reloadPage(){
            window.location.reload();
        }
    </script>
@endsection
