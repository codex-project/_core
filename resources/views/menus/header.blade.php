<c-header-menu-item v-on:click.native="showSidenav('{{ $menu->getId() }}')" slot="menu" {!!  $menu->parseAttributes()  !!}></c-header-menu-item>

<c-side-nav
    slot="after"
    :is-opened="isSidenav('{{ $menu->getId() }}')"
    :right="sidenavs.right"
    :width="sidenavs.width"
    :transition="sidenavTransition"
    v-on:after-leave="hideSidenav">

    {{--<c-side-nav ref="sidenav-{{ $menu->getId() }}" id="sidenav-{{ $menu->getId() }}">--}}
    <li><a class="subheader">{{  $menu->attr('title') }}</a></li>
    @foreach($items as $item)
        <li><a {!!  $item->parseAttributes()  !!}>{{ $item->getValue() }}</a></li>
    @endforeach
</c-side-nav>
