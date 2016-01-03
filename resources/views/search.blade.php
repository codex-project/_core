@extends('codex::layouts.codex')

@section('sidebar')
	<div class="panel panel-default">
		<div class="panel-heading">
			<h3 class="panel-title">Table of Contents</h3>
		</div>

		<div class="panel-body">
			{!! $toc['body'] !!}
		</div>
	</div>
@endsection

@section('content')
	<div class="page-header">
		<h1>Search Results For <small>{{ $search }}</small></h1>
	</div>

	{{ dd($results) }}
	
@endsection