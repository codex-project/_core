<c-header-menu-item v-on:click.native="showSidenav('{{ $menu->getId() }}')" slot="menu" {!!  $menu->parseAttributes()  !!}></c-header-menu-item>

<c-side-nav
        slot="after"
        :is-opened="isSidenav('{{ $menu->getId() }}')"
        :right="sidenavs.right"
        :width="sidenavs.width"
        :transition="sidenavTransition"
        v-on:after-leave="hideSidenav">


    <c-side-nav-item :header="true">{{ $menu->attr('title') }}</c-side-nav-item>
    @include('codex::menus.header-child', compact('items'))


</c-side-nav>
