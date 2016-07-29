
<ul class="dropdown-nav">
    <li class="dropdown">
        <a class="dropdown-toggle" type="button" id="dropdown-menu-versions" data-toggle="dropdown" aria-expanded="true">
            <span class="subtitle">version</span>
            @yield('projectRef', $ref)
            <span class="caret"></span>
        </a>
        <ul class="dropdown-menu pull-right" role="menu" aria-labelledby="dropdown-menu-versions">
            @foreach($project->refs->getSorted() as $ref)
                <li role="presentation">
                    <a role="menuitem" tabindex="-1" href="{{ $project->url(null, $ref) }}">{{ $ref }}</a>
                </li>
            @endforeach
        </ul>
    </li>
</ul>
