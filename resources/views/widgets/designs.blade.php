<div class="col-xs-12 Card pd-btm-50 position-relative" style="padding-left: 10px; padding-right: 10px">
    <img class="Icon img img-responsive" src="{{ URL::to('images/design.png') }}" alt="design">
    <h3 class="color-red" style="margin-left: 50px">My designs</h3>
    @if($designs->count() > 0)
        @foreach($designs as $design)
            <design-show :design="{{ $design }}" add-class="Thumbnail col-xs-6"></design-show>
        @endforeach
        <a href="{{ route('designs.index') }}" class="Button--red stick-to-bottom color-white">
            See all designs
        </a>
    @else
        <p style="margin-right: 40px; margin-left: 40px">Seems like you don't have any designs... yet.</p>
        <a href="{{ route('categories.index') }}" class="Button--red stick-to-bottom color-white">
            Create a new design
        </a>
    @endif
</div>