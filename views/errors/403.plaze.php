<@extends('errors::layout')

<@section('title', 'Forbidden')
<@section('code', 403)
<@section('message', $exception->getMessage() ?: 'Forbidden')
