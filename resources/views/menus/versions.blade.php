
<div class="switcher">
    <div class="dropdown">
        <button class="btn dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-expanded="true">
            @yield('projectRef', $project->getRef())
            <span class="caret"></span>
        </button>
        <ul class="dropdown-menu" role="menu" aria-labelledby="dropdownMenu1">
            @foreach($project->getSortedRefs() as $ref)
                <li role="presentation">
                    <a role="menuitem" tabindex="-1" href="{{ $project->url(null, $ref) }}">{{ $ref }}</a>
                </li>
            @endforeach
        </ul>
    </div>
</div>

