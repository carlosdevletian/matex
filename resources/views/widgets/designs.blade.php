<div class="col-xs-12 Card pd-btm-50">
    <h3 class="color-red">Your designs</h3>
    @if($designs->count() > 0)
        @foreach($designs as $design)
            <a role="button" @click="openImageModal({{ $design }})" class="col-sm-2 col-xs-6 mg-btm-20 position-relative">
                <div class="background-image" style="height: 100px; background-image: url('{{  route('image_path', ['image' => $design->image_name]) }}')" 
                    >
                    <!-- <div style="position: absolute; bottom: 0; left: 0; text-align: center; width: 100%; color: white">
                        Bracelet
                    </div> -->
                </div>
                <div class="Banner box-shadow">Bracelet</div>
                    <!-- @mouseover="removeBackground('{{  route('image_path', ['image' => $design->image_name]) }}', $event)"
                    @mouseout="setBackground('{{  route('image_path', ['image' => $design->image_name]) }}', $event)" -->
                <!-- linear-gradient(rgba(255, 240, 230, 0.8), rgba(255, 240, 230, 0.8)), -->
            </a>
        @endforeach
        <br>
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