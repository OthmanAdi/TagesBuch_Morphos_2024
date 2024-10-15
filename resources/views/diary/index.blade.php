    <!DOCTYPE html>
    <html lang="de">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Mein Digitales Tagebuch</title>
        <link href="<https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css>" rel="stylesheet">
    </head>

    <body class="bg-gray-100">
        <div class="container mx-auto px-4 py-8">
            <h1 class="text-3xl font-bold mb-8">Mein Digitales Tagebuch</h1>

            @if (session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4"
                role="alert">
                {{ session('success') }}
            </div>
            @endif

            <a href="{{ route('diary.create') }}"
                class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded mb-4 inline-block">Neuer
                Eintrag</a>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                @foreach ($entries as $entry)
                <div class="bg-white shadow-md rounded-lg p-4">
                    <h2 class="text-xl font-semibold mb-2">{{ $entry['title'] }}</h2>
                    <p class="text-gray-600 mb-2">{{ $entry['date'] }}</p>
                    <p class="mb-4">{{ Str::limit($entry['content'], 100) }}</p>
                    <div class="flex justify-between">
                        <a href="{{ route('diary.show', $entry['id']) }}" class="text-blue-500 hover:text-blue-700">Mehr
                            lesen</a>
                        <span
                            class="text-{{ $entry['mood'] === 'happy' ? 'green' : ($entry['mood'] === 'sad' ? 'red' : 'yellow') }}-500">
                            {{ $entry['mood'] === 'happy' ? '😊' : ($entry['mood'] === 'sad' ? '😢' : '😐') }}
                        </span>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </body>

    </html>