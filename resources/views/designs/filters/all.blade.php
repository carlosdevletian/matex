<form method="GET" action="{{ route('designs.index') }}" class="text-center">
        <div class="row visible-xs-block">
            <div class="col-xs-12">
                <div class="row">
                    @include('designs.filters.category')
                    @include('designs.filters.date')
                </div>
            </div>
            <div class="col-xs-12 mg-top-10">
                <div class="row">
                    <button class="Button--product">Go</button>
                    <a class="Button--product" href="{{ route('designs.index') }}" style="padding: 7px">Reset Filters</a>
                </div>
            </div>
        </div>
        <div class="row hidden-xs">
            @include('designs.filters.category')
            @include('designs.filters.date')
            <button class="Button--product">Go</button>
            <a class="Button--product" href="{{ route('designs.index') }}" style="padding: 7px">Reset Filters</a>
        </div>
</form>
