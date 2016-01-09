@push('page-actions')

<div class="btn-group">
    <a href="#" type="button" data-toggle="dropdown" aria-expanded="false" class="dropdown-toggle btn btn-primary btn-sm">
        @yield('projectName', isset($project) ? $project->config('display_name') : 'Project')
    </a>

    <div class="dropdown-menu dropdown-menu-packadic">

        {!! $codex->getMenus()->get('projects')->render() !!}
    </div>
</div>

@if(isset($project))
    <div class="btn-group">
        <a href="#" type="button" data-toggle="dropdown" aria-expanded="false" class="dropdown-toggle btn btn-primary btn-sm">
            @yield('projectRef', $project->getRef())
        </a>

        <div class="dropdown-menu dropdown-menu-packadic ">
            @foreach($project->getSortedRefs() as $ref)
                <a href="{{ $project->url(null, $ref) }}" class="dropdown-item">{{ $ref }}</a>
            @endforeach
        </div>

    </div>
@endif

@endpush
