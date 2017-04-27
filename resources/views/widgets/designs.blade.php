<div class="col-xs-12 Card Card--dashboard position-relative pd-btm-50" style="padding-left: 10px; padding-right: 10px">
    <p class="Card__title" style="margin-left: 15px">Designs</p>
    @if($designs->count() > 0)
        @foreach($designs as $design)
            <design-show :design="{{ $design }}" add-class="Thumbnail col-xs-6" admin="{{ auth()->user()->hasRole('admin') }}"></design-show>
        @endforeach
        @if(auth()->user()->hasRole('admin'))
            <a href="{{ route('designs.index', $profileUser) }}" class="Button--card stick-to-bottom">
                ALL DESIGNS
            </a>
        @else
            <a href="{{ route('designs.index') }}" class="Button--card stick-to-bottom">
                ALL DESIGNS
            </a>
        @endif
    @else
        @if(auth()->user()->hasRole('admin'))
            <p style="margin-right: 40px; margin-left: 40px">This user has no designs</p>
        @else
            <p style="margin-right: 20px; margin-left: 20px">Seems like you don't have any designs... yet.</p>
            <a href="{{ route('categories.index') }}" class="Button--card stick-to-bottom">
                CREATE DESIGN
            </a>
        @endif
    @endif
</div>