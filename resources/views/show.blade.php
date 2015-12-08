@extends('docit::layouts.docit')

@section('sidebar')
	{!! $toc['body'] !!}
@endsection

@section('before_content')
	@if (isset($content['frontmatter']['title']))
		<div class="row">
			<div class="page-header">
				<h1>{{ $content['frontmatter']['title'] }}</h1>
			</div>
		</div>
	@endif
@endsection

@section('content')
	{!! $content['body'] !!}
@endsection