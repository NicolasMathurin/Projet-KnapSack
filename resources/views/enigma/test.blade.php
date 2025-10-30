<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Document</title>
</head>
<body>
<form action="{{route('enigma.random')}}" method="post">
    @csrf
    <input type="checkbox" name="difficulty1" value="facile" id="facile" checked>
    <label for="facile">Facile</label>
    <input type="checkbox" name="difficulty2" value="moyenne" id="moyenne">
    <label for="moyenne">Moyenne</label>
    <input type="checkbox" name="difficulty3" value="difficile" id="difficile">
    <label for="difficile">Difficile</label>
    <button type="submit" class="buy">Test random énigme</button>
</form>
</body>
</html>
