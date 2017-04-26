<div class="Form__select mg-rgt-10">
    <select name="category">
        <option selected disabled>Filter by products</option>
        <option value>All Designs</option>
        @foreach($categories as $category)
            <option value="{{ $category->slug_name }}" {{ request('category') == $category->slug_name ? 'selected' : '' }}>
                {{ $category->name }}
            </option>
        @endforeach
    </select>
</div>