<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="@yield('meta_description', 'Platform belajar bahasa dan budaya Jepang dari UKM Nihon STIS')">
    <title>@yield('title', 'NihonLearn') — UKM Nihon STIS</title>

    <!-- Fonts: Japanese Typography System -->
    <link href="https://fonts.googleapis.com/css2?family=Sawarabi+Mincho&family=Zen+Kurenaido&family=Noto+Sans+JP:wght@300;400;500;700&family=M+PLUS+Rounded+1c:wght@400;500;700&family=Newsreader:ital,opsz,wght@0,6..72,200..800;1,6..72,200..800&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">

    <!-- Global Typography & Color System -->
    <style>
        :root {
            --color-background: #F5F0E8;
            --color-surface: #FFFFFF;
            --color-text-primary: #1A1A2E;
            --color-text-muted: #6B7280;
            --color-accent-green: #2D6A4F;
            --color-accent-red: #C0392B;
            --color-accent-orange: #E76F51;
            --color-accent-gold: #B8860B;
            --color-level-pemula: #16A34A;
            --color-level-menengah: #D97706;
            --color-level-mahir: #DC2626;
            --color-border: #E5E0D8;
        }

        body {
            font-family: 'Noto Sans JP', sans-serif;
            font-size: 1.0625rem;
            font-weight: 400;
            line-height: 1.8;
            color: var(--color-text-primary);
            background-color: var(--color-background);
            /* Fix navbar layout shift: reserve scrollbar space agar tidak geser */
            scrollbar-gutter: stable;
            overflow-x: hidden;
        }

        h1, .heading-h1 {
            font-family: 'Zen Kurenaido', serif;
            font-weight: 700;
            line-height: 1.2;
            letter-spacing: 0.02em;
            color: var(--color-text-primary);
            text-shadow: 0 1px 3px rgba(0, 0, 0, 0.08), 0 2px 8px rgba(0, 0, 0, 0.04);
        }
        h2, .heading-h2 {
            font-family: 'Sawarabi Mincho', serif;
            font-weight: 400;
            line-height: 1.3;
            color: var(--color-text-primary);
            text-shadow: 0 1px 2px rgba(0, 0, 0, 0.06);
        }
        h3, .heading-h3 {
            font-family: 'Noto Sans JP', sans-serif;
            font-weight: 700;
            line-height: 1.4;
            color: var(--color-text-primary);
        }

        .highlight-note {
            font-family: 'M PLUS Rounded 1c', sans-serif;
            font-size: 0.9375rem;
            font-weight: 500;
            line-height: 1.6;
        }
        .jp-character-large {
            font-family: 'Noto Sans JP', sans-serif;
            font-weight: 700;
            color: var(--color-accent-green);
        }

        .note-box {
            font-family: 'M PLUS Rounded 1c', sans-serif;
            background: #FEF9EC;
            border-left: 4px solid var(--color-accent-orange);
            border-radius: 0 8px 8px 0;
            padding: 1rem 1.25rem;
            margin: 1.5rem 0;
        }
        .note-label {
            font-weight: 700;
            color: var(--color-accent-orange);
            display: block;
            margin-bottom: 0.5rem;
            font-size: 0.875rem;
            text-transform: uppercase;
            letter-spacing: 0.05em;
        }
        .example-box {
            background: #F0F7F4;
            border: 1px solid #A8D5C2;
            border-radius: 8px;
            padding: 1.25rem;
            margin: 1.5rem 0;
            display: flex;
            flex-direction: column;
            gap: 0.25rem;
        }

        /* Consistent container */
        .site-container {
            max-width: 1280px;
            margin: 0 auto;
            padding: 0 2rem;
            width: 100%;
        }
    </style>

    <!-- Preserved CSS from original -->
    <link rel="stylesheet" href="{{ asset('css/sakura.css') }}">
    <link rel="stylesheet" href="{{ asset('css/footer.css') }}">
    @stack('styles')

    <!-- Vite (Tailwind + Alpine) -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen flex flex-col">

    @include('components.navbar')

    <main class="flex-1">
        @yield('content')
    </main>

    @include('components.footer')

    <!-- Preserved JS from original -->
    <script src="{{ asset('js/sakura.js') }}"></script>
    @stack('scripts')

</body>
</html>
