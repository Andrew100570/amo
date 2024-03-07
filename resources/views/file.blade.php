<style>
    .red-circle {
        width: 20px;
        height: 20px;
        background-color: {{ $color }};
        border-radius: 50%;
        display: inline-block;
    }
</style>
<form action="{{ route('upload') }}" method="POST" enctype="multipart/form-data">
    @csrf
    <input type="file" name="file">
    <button type="submit">Загрузить файл</button>
</form>


@if (!empty($data))
    @foreach ($data as $text)
        <p>{{ $text }}</p>
    @endforeach
@else
    <p>Файл не загружен</p>

@endif

<div class="red-circle"></div>
