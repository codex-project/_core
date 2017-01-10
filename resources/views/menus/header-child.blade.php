@foreach($items as $item)
    @if($item->hasChildren())
        <c-side-nav-item :has-children="true">
            <span slot="title" {!!  $item->parseAttributes()  !!}>{{ $item->getValue() }}</span>
            @include('codex::menus.header-child', ['items' => $item->getChildren()])
        </c-side-nav-item>
    @else
        <c-side-nav-item {!!  $item->parseAttributes()  !!}>{{ $item->getValue() }}</c-side-nav-item>
    @endif
@endforeach