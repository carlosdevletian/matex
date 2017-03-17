<div class="col-xs-12 Card pd-btm-50 position-relative" style="padding-left: 10px; padding-right: 10px">
    <div class="background-image Icon Icon--design"></div>
    <h3 class="color-red" style="margin-left: 50px">My designs</h3>
    @if($designs->count() > 0)
        @foreach($designs as $design)
            <a role="button" @click="openImageModal({{ $design }})" class="Thumbnail col-xs-6 mg-btm-20">
                <div class="Card Card--thumbnail position-relative mg-0">
                    <div class="background-image Thumbnail--image" 
                        style="background-image: url('{{  route('image_path', ['image' => $design->image_name]) }}');">
                    </div>
                    <div class="text-center">Bracelet</div>
                </div>
            </a>
        @endforeach
        <!-- <a href="{{ route('categories.index') }}" class="Thumbnail col-xs-6 mg-btm-20 position-relative" title="Create a new design">
            <div class="Card Card--thumbnail position-relative mg-0">
                <div class="background-image position-relative Icon--add">
                </div>
                <div class="text-center">Add</div>
            </div>
        </a>
        <br> -->
        <a href="{{ route('designs.index') }}" class="Button--red stick-to-bottom color-white">
            See all designs
        </a>
    @else
        <p>Seems like you don't have any designs... yet.</p>
        <a href="{{ route('categories.index') }}" class="Button--red stick-to-bottom color-white">
            Create a new design
        </a>
    @endif
</div>