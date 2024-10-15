<!DOCTYPE html>
<html lang="de">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Neuer Eintrag - Mein Digitales TagesBuch</title>
</head>

<body>
    <h1>
        Neuer Tagesbucheintrag
    </h1>

    <form action="{{ route('diary.store') }}" method="POST">
        @csrf
        <div>
            <label for="date">Datum: </label>
            <input type="date" id="date" name="date" required>
        </div>
        <div>
            <label for="title">Titel: </label>
            <input type="text" id="title" name="title" required>
        </div>
        <div>
            <label for="content">Inhalt: </label>
            <textarea id="content" name="content" required></textarea>
        </div>
        <div>
            <label for="mood">Stimmung: </label>
            <select id="mood" name="mood" required>
                <option value="happy">Happy</option>
                <option value="neutral">Neutral</option>
                <option value="sad">Sad</option>
            </select>
        </div>
        <button type="submit">Eintrag Erstellen</button>
        <a href="{{ route('diary.index') }}">Abbrechen</a>
    </form>
</body>

</html>