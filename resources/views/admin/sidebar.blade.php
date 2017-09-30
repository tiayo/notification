<div class="left-sidebar">
    <div class="left-sidebar-header">
        <div class="left-sidebar-title color-light">{{config('site.title')}}</div>
        <div class="left-sidebar-toggle c-hamburger c-hamburger--htla hidden-xs" data-toggle-class="left-sidebar-collapsed" data-target="html">
            <span></span>
        </div>
    </div>
    <div id="left-nav" class="nano has-scrollbar">
        <div class="nano-content" tabindex="0" style="right: -15px;">
            <nav>
                <ul class="nav" id="main-nav">
                    @php
                        $sidebars = config('sidebar');
                    @endphp

                    @foreach($sidebars as $key => $sidebar)
                        @php
                            if(isset($sidebar['can']) && !empty($sidebar['can']) && !can($sidebar['can'])) {
                                continue;
                            }
                        @endphp

                        @if (!isset($sidebar['child']) || empty($sidebar['child']))
                            <li id="{{ $key }}"><a href="{{ route($sidebar['route']) }}">
                                    <i class="fa fa-{{ $sidebar['icon'] }}" aria-hidden="true"></i>
                                    <span>{{ $sidebar['name'] }}</span></a>
                            </li>
                        @endif

                        @if (isset($sidebar['child']) && !empty($sidebar['child']))
                                <li id="{{ $key }}" class="has-child-item close-item">
                                    <a>
                                        <i class="fa fa-{{ $sidebar['icon'] }}" aria-hidden="true"></i>
                                        <span>{{ $sidebar['name'] }}</span>
                                    </a>
                                    <ul class="nav child-nav level-1">
                                        @foreach($sidebar['child'] as $num => $child)
                                            <li id="{{ $num }}">
                                                <a href="{{ route($child['route']) }}">{{ $child['name'] }}</a>
                                            </li>
                                        @endforeach
                                    </ul>
                                </li>
                        @endif
                    @endforeach
                </ul>
            </nav>
        </div>
        <div class="nano-pane" style=""><div class="nano-slider" style="height: 443px; transform: translate(0px, 0px);"></div></div></div>
</div>