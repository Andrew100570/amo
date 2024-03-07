<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    @vite(['resources/js/field.js'])
</head>
<body>


<select id="typeSelect">
    <option >Значение не выбрано</option>
    <option value="type1">Type 1</option>
    <option value="type2">Type 2</option>
    <option value="type3">Type 3</option>
</select>

<div id="dynamicFields">
    <input type="text" name="type1_field1" placeholder="Type 1 Field 1">
    <input type="text" name="type2_field1" placeholder="Type 2 Field 1">
    <input type="text" name="type2_field2" placeholder="Type 2 Field 2">
    <input type="text" name="type3_field1" placeholder="Type 3 Field 1">
    <input type="text" name="type3_field2" placeholder="Type 3 Field 2">
    <input type="text" name="type3_field3" placeholder="Type 3 Field 3">
</div>


<script src="{{ asset('js/field.js') }}"></script>
</body>
</html>
