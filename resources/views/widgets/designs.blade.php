<div class="col-xs-12 Card">
    @foreach($designs as $design)
        <a role="button" @click="openImageModal({{ $design }})">
            <img src="{{ route('image_path', ['image' => $design->image_name]) }}" class="img img-responsive box-shadow margin-auto mg-btm-20">
        </a>
    @endforeach
    <a href="{{ route('designs.index') }}">
        See all designs
    </a>
</div>