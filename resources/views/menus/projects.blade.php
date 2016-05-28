<ul class="main-nav">
    <li class="dropdown community-dropdown">
        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
            {{--@yield('projectName', isset($project) ? $project->config('display_name') : 'Project')--}}
            Projects
            <span class="caret"></span>
        </a>
        <ul class="dropdown-menu" role="menu">
            @include('codex::menus.projects-child')
        </ul>
    </li>
</ul>