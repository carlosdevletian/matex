<div class="Form__select">
    <select name="date">
        <option selected disabled>Sort by date</option>
        <option value="desc" {{ request('date') == "desc" ? 'selected' : '' }}>Latest</option>
        <option value="asc" {{ request('date') == "asc" ? 'selected' : '' }}>Oldest</option>
    </select>
</div>