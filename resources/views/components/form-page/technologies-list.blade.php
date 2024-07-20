<select id="technologies" name="technologies[]" multiple>
    @foreach($technologies as $technology)
    <option value="{{ $technology->name }}">{{ $technology->name }}</option>
    @endforeach
</select>