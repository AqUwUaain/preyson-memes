<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PreySON - Admin Dashboard</title>
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
        }

        nav {
            background: #ffffff;
            border-bottom: 3px solid #facc15;
            padding: 0.9rem 2.5rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
            box-shadow: 0 4px 15px rgba(59, 7, 100, 0.06);
        }

        .brand-container {
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }

        .brand-logo {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            object-fit: cover;
            border: 2px solid #facc15;
        }

        .brand-title {
            font-size: 1.35rem;
            font-weight: 900;
            color: #3b0764;
        }

        .nav-actions {
            display: flex;
            gap: 1.25rem;
            align-items: center;
        }

        .btn-live {
            color: #581c87;
            text-decoration: none;
            font-weight: 700;
            font-size: 0.95rem;
        }

        .btn-live:hover {
            color: #eab308;
        }

        .btn-logout {
            background: #faf5ff;
            color: #7e22ce;
            border: 2px solid #d8b4fe;
            padding: 0.5rem 1.1rem;
            border-radius: 8px;
            cursor: pointer;
            font-weight: 700;
            font-size: 0.85rem;
            transition: all 0.2s;
        }

        .btn-logout:hover {
            background: #ef4444;
            color: #ffffff;
            border-color: #ef4444;
        }

        .container {
            max-width: 900px;
            margin: 2.5rem auto;
            padding: 0 1.5rem;
        }

        .welcome-header {
            margin-bottom: 2rem;
        }

        .welcome-header h1 {
            font-size: 2.2rem;
            color: #3b0764;
            font-weight: 900;
        }

        .alert-success {
            background: #fef08a;
            border: 2px solid #eab308;
            color: #713f12;
            padding: 0.9rem 1.25rem;
            border-radius: 12px;
            font-weight: 700;
            margin-bottom: 2rem;
        }

        .alert-error {
            background: #fee2e2;
            border: 2px solid #f87171;
            color: #991b1b;
            padding: 0.9rem 1.25rem;
            border-radius: 12px;
            margin-bottom: 2rem;
            font-weight: 600;
        }

        .upload-card {
            background: #ffffff;
            border: 2px solid #f3e8ff;
            border-radius: 18px;
            padding: 2rem;
            box-shadow: 0 10px 30px rgba(59, 7, 100, 0.06);
            margin-bottom: 3rem;
        }

        .upload-card h2 {
            font-size: 1.4rem;
            color: #3b0764;
            font-weight: 800;
            margin-bottom: 0.5rem;
        }

        .upload-card p.subtitle {
            color: #6b21a8;
            font-size: 0.9rem;
            margin-bottom: 1.5rem;
        }

        .form-group {
            margin-bottom: 1.5rem;
        }

        .form-group label {
            display: block;
            margin-bottom: 0.5rem;
            font-weight: 700;
            color: #4c1d95;
            font-size: 0.95rem;
        }

        .form-group input[type="text"],
        .form-group input[type="file"] {
            width: 100%;
            padding: 0.85rem 1rem;
            border-radius: 10px;
            border: 2px solid #e9d5ff;
            background: #faf5ff;
            color: #3b0764;
            font-size: 1rem;
            outline: none;
            transition: border-color 0.2s;
        }

        .form-group input:focus {
            border-color: #eab308;
        }

        .btn-yellow {
            background: #facc15;
            color: #3b0764;
            border: 2px solid #eab308;
            box-shadow: 0 4px 0 #ca8a04;
            padding: 0.85rem 2rem;
            font-size: 1rem;
            font-weight: 800;
            border-radius: 10px;
            cursor: pointer;
            transition: transform 0.1s, box-shadow 0.1s;
        }

        .btn-yellow:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 0 #ca8a04;
        }

        .btn-yellow:active {
            transform: translateY(2px);
            box-shadow: 0 1px 0 #ca8a04;
        }

        .history h3 {
            font-size: 1.3rem;
            margin-bottom: 1rem;
            color: #3b0764;
            font-weight: 800;
        }

        .grid-history {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
            gap: 1.25rem;
        }

        .history-card {
            border: 1px solid #e9d5ff;
            border-radius: 12px;
            overflow: hidden;
            background: #faf5ff;
        }

        .history-card img, .history-card video {
            width: 100%;
            height: 140px;
            object-fit: cover;
            display: block;
        }

        .history-card p {
            padding: 0.6rem;
            font-weight: 700;
            font-size: 0.85rem;
            color: #3b0764;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }
    </style>
</head>
<body>

    <nav>
        <div class="brand-container">
            <img src="{{ asset('logo.png') }}" alt="PreySON Logo" class="brand-logo">
            <span class="brand-title">PreySON Creator Studio</span>
        </div>
        <div class="nav-actions">
            <a href="/" class="btn-live" target="_blank">View Live Feed &nearr;</a>
            <form action="/logout" method="POST" style="display:inline;">
                @csrf
                <button type="submit" class="btn-logout">Sign Out</button>
            </form>
        </div>
    </nav>

    <div class="container">
        <div class="welcome-header">
            <h1>Upload Center</h1>
            <p style="color: #6b21a8; font-weight: 600;">Drop your memes, videos, GIFs, or batch-upload an entire ZIP archive.</p>
        </div>

        @if(session('success'))
            <div class="alert-success">
                {{ session('success') }}
            </div>
        @endif

        @if($errors->any())
            <div class="alert-error">
                @foreach ($errors->all() as $error)
                    <p>{{ $error }}</p>
                @endforeach
            </div>
        @endif

        <div class="upload-card">
            <h2>Upload Content</h2>
            <p class="subtitle">Supports single files (PNG, JPG, GIF, MP4) or complete .ZIP archives. For ZIP uploads, each file's name is used as the meme title.</p>
            
            <form action="{{ route('posts.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="form-group">
                    <label for="title">Meme Title / Caption (Optional if uploading ZIP)</label>
                    <input type="text" id="title" name="title" placeholder="Leave blank to use original file name">
                </div>

                <div class="form-group">
                    <label for="media">Select File or .ZIP Archive</label>
                    <input type="file" id="media" name="media" accept="image/*,video/mp4,video/webm,video/quicktime,.zip" required>
                </div>

                <button type="submit" class="btn-yellow">🚀 Publish Media</button>
            </form>
        </div>

        <div class="history">
            <h3>Uploaded Content ({{ $posts->count() }})</h3>
            <div class="grid-history">
                @foreach($posts as $post)
                    <div class="history-card">
                        @if($post->media_type === 'video')
                            <video src="{{ asset('storage/' . $post->media_path) }}"></video>
                        @else
                            <img src="{{ asset('storage/' . $post->media_path) }}" alt="{{ $post->title }}">
                        @endif
                        <p>{{ $post->title }}</p>
                    </div>
                @endforeach
            </div>
        </div>
    </div>

</body>
</html>