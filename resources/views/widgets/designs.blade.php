<div class="col-xs-12 Card pd-btm-50 position-relative" style="padding-left: 10px; padding-right: 10px">
    <img class="Icon img img-responsive" src="{{ URL::to('images/design.png') }}" alt="design">
    <h3 class="color-red" style="margin-left: 50px">Designs</h3>
    @if($designs->count() > 0)
        @foreach($designs as $design)
            <design-show :design="{{ $design }}" add-class="Thumbnail col-xs-6" admin="{{ auth()->user()->hasRole('admin') }}"></design-show>
        @endforeach
        @if(auth()->user()->hasRole('admin'))
            <a href="{{ route('designs.index', $profileUser) }}" class="Button--red stick-to-bottom color-white">
                See all designs
            </a>
        @else
            <a href="{{ route('designs.index') }}" class="Button--red stick-to-bottom color-white">
                See all designs
            </a>
        @endif
    @else
        @if(auth()->user()->hasRole('admin'))
            <p style="margin-right: 40px; margin-left: 40px">This user has no designs</p>
        @else
            <p style="margin-right: 40px; margin-left: 40px">Seems like you don't have any designs... yet.</p>
            <a href="{{ route('categories.index') }}" class="Button--red stick-to-bottom color-white">
                Create a new design
            </a>
        @endif
    @endif
</div>