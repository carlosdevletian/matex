<div class="row">
    <div class="col-xs-12">
        <ol class="breadcrumb" style="background-color: transparent;">
            @foreach($links as $name => $link)
                @if($name === 'active')
                    <li class="active color-secondary">{{ $link }}</li>
                @else
                    <li><a class="color-secondary" href="{{ $link }}">{{ $name }}</a></li>
                @endif
            @endforeach
        </ol>
    </div>
</div>