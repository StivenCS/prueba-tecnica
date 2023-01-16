<div>
    {{ $data["description"] }}
</div>
@if(isset($data["description"]) && !is_null($data["description"]))
    <strong> {{ $data['description'] }} </strong>
@endif
