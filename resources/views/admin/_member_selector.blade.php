<select name="{{ $fieldname ?? 'member_id' }}"
        class="w-full grow rounded-md {{ !empty($class) ? ' '. $class : '' }}"
        {{ !empty($autofocus) ? 'autofocus' : '' }}
        id="{{ $field_id ?? $fieldname }}">
    @foreach ($users as $u)
        <option value="{{ $u->id }}"
            {{ $u->id == ($current ?? null) ? 'selected' : '' }}>
            {{ $u->nickname }}
        </option>
    @endforeach
</select>
