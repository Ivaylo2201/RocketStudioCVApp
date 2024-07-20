<select required name="university" id="university">
    <option value="" grade="0" disabled selected>Изберете университет</option>
    @foreach($universities as $university)
    <option value="{{ $university->name }}" grade="{{ $university->grade }}">{{ $university->name }}</option>
    @endforeach
</select>