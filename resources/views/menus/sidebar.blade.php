
<section class="sidebar" data-layout="sidebar">
    <ul>
        <li class="title">{{ $project->getDisplayName() }}</li>
        @include('codex::menus.sidebar-child')
    </ul>
</section>
