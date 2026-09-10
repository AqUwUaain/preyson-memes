<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PreySON | Meme Vault</title>
    <style>
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        body {
            background: #ffffff;
            color: #3b0764;
            line-height: 1.6;
        }

        header {
            background: #ffffff;
            border-bottom: 3px solid #facc15;
            padding: 1rem 2.5rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
            box-shadow: 0 4px 15px rgba(59, 7, 100, 0.06);
            position: sticky;
            top: 0;
            z-index: 100;
        }

        .brand-container {
            display: flex;
            align-items: center;
            gap: 0.85rem;
            text-decoration: none;
        }

        .brand-logo {
            width: 44px;
            height: 44px;
            border-radius: 50%;
            object-fit: cover;
            border: 2px solid #facc15;
        }

        .brand-name {
            font-size: 1.6rem;
            font-weight: 900;
            color: #4c1d95;
            letter-spacing: -0.5px;
        }

        .admin-link {
            font-size: 0.95rem;
            font-weight: 800;
            color: #3b0764;
            text-decoration: none;
            padding: 0.6rem 1.4rem;
            border-radius: 10px;
            background: #facc15;
            border: 2px solid #eab308;
            box-shadow: 0 3px 0 #ca8a04;
            transition: transform 0.1s, box-shadow 0.1s;
        }

        .admin-link:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 0 #ca8a04;
        }

        .admin-link:active {
            transform: translateY(2px);
            box-shadow: 0 1px 0 #ca8a04;
        }

        .container {
            max-width: 680px;
            margin: 2.5rem auto;
            padding: 0 1rem;
        }

        .hero {
            margin-bottom: 2.5rem;
            text-align: center;
        }

        .hero h1 {
            font-size: 2.5rem;
            color: #3b0764;
            font-weight: 900;
        }

        .hero p {
            color: #581c87;
            font-size: 1.1rem;
            font-weight: 600;
        }

        .meme-feed {
            display: flex;
            flex-direction: column;
            gap: 2.5rem;
        }

        .meme-card {
            background: #ffffff;
            border: 2px solid #f3e8ff;
            border-radius: 18px;
            overflow: hidden;
            box-shadow: 0 8px 25px rgba(59, 7, 100, 0.08);
            transition: transform 0.2s, border-color 0.2s;
        }

        .meme-card:hover {
            border-color: #facc15;
        }

        .meme-header {
            padding: 1.25rem 1.5rem;
            border-bottom: 1px solid #f3e8ff;
        }

        .meme-header h2 {
            font-size: 1.35rem;
            font-weight: 800;
            color: #3b0764;
        }

        .meme-media-wrapper {
            background: #090314;
            display: flex;
            justify-content: center;
            align-items: center;
            max-height: 600px;
            overflow: hidden;
        }

        .meme-media-wrapper img, 
        .meme-media-wrapper video {
            width: 100%;
            max-height: 600px;
            object-fit: contain;
            display: block;
        }

        .meme-footer {
            padding: 1rem 1.5rem;
            background: #faf5ff;
            font-size: 0.85rem;
            font-weight: 700;
            color: #6b21a8;
            display: flex;
            justify-content: space-between;
        }

        .badge {
            background: #facc15;
            color: #3b0764;
            padding: 0.2rem 0.6rem;
            border-radius: 6px;
            font-size: 0.75rem;
            font-weight: 800;
        }

        .empty-state {
            text-align: center;
            padding: 4rem 1rem;
            background: #faf5ff;
            border: 2px dashed #d8b4fe;
            border-radius: 16px;
        }

        .empty-state h3 {
            color: #3b0764;
            margin-bottom: 0.5rem;
        }
    </style>
</head>
<body>

    <header>
        <a href="/" class="brand-container">
            <img src="{{ asset('logo.png') }}" alt="PreySON Logo" class="brand-logo">
            <span class="brand-name">PreySON</span>
        </a>
        @auth
            <a href="/dashboard" class="admin-link">Dashboard</a>
        @else
            <a href="/login" class="admin-link">Admin Portal</a>
        @endauth
    </header>

    <div class="container">
        <section class="hero">
            <h1>Daily Dose of Memes</h1>
            <p>Direct from the PreySON vault.</p>
        </section>

        <section class="meme-feed">
            @forelse ($posts as $post)
                <article class="meme-card">
                    <div class="meme-header">
                        <h2>{{ $post->title }}</h2>
                    </div>

                    <div class="meme-media-wrapper">
                        @if ($post->media_type === 'video')
                            <video src="{{ asset('storage/' . $post->media_path) }}" controls loop playsinline></video>
                        @else
                            <img src="{{ asset('storage/' . $post->media_path) }}" alt="{{ $post->title }}" loading="lazy">
                        @endif
                    </div>

                    <div class="meme-footer">
                        <span>Posted {{ $post->created_at->diffForHumans() }}</span>
                        <span class="badge">{{ strtoupper($post->media_type) }}</span>
                    </div>
                </article>
            @empty
                <div class="empty-state">
                    <h3>No memes dropped yet!</h3>
                    <p style="color: #6b21a8;">Login as Admin to upload your first meme, video, or GIF.</p>
                </div>
            @endforelse
        </section>
    </div>

</body>
</html>