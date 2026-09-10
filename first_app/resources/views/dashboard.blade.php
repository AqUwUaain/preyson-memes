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

        .btn-logout {
            background: #faf5ff;
            color: #7e22ce;
            border: 2px solid #d8b4fe;
            padding: 0.5rem 1.1rem;
            border-radius: 8px;
            cursor: pointer;
            font-weight: 700;
            font-size: 0.85rem;
        }

        .container {
            max-width: 960px;
            margin: 2.5rem auto;
            padding: 0 1.5rem;
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

        .upload-card {
            background: #ffffff;
            border: 2px solid #f3e8ff;
            border-radius: 18px;
            padding: 2rem;
            box-shadow: 0 10px 30px rgba(59, 7, 100, 0.06);
            margin-bottom: 3rem;
        }

        .form-group {
            margin-bottom: 1.25rem;
        }

        .form-group label {
            display: block;
            margin-bottom: 0.5rem;
            font-weight: 700;
            color: #4c1d95;
            font-size: 0.95rem;
        }

        .form-group input {
            width: 100%;
            padding: 0.85rem 1rem;
            border-radius: 10px;
            border: 2px solid #e9d5ff;
            background: #faf5ff;
            color: #3b0764;
            font-size: 1rem;
            outline: none;
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
        }

        .batch-bar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            background: #faf5ff;
            border: 2px solid #f3e8ff;
            padding: 1rem 1.5rem;
            border-radius: 12px;
            margin-bottom: 1.5rem;
        }

        .btn-danger {
            background: #ef4444;
            color: white;
            border: none;
            padding: 0.6rem 1.25rem;
            border-radius: 8px;
            font-weight: 800;
            cursor: pointer;
            transition: opacity 0.2s;
        }

        .btn-danger:disabled {
            opacity: 0.4;
            cursor: not-allowed;
        }

        .grid-history {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
            gap: 1.25rem;
        }

        .history-card {
            border: 2px solid #f3e8ff;
            border-radius: 12px;
            overflow: hidden;
            background: #ffffff;
            position: relative;
            box-shadow: 0 4px 10px rgba(59, 7, 100, 0.04);
        }

        .history-card input[type="checkbox"] {
            position: absolute;
            top: 10px;
            left: 10px;
            width: 22px;
            height: 22px;
            accent-color: #7c3aed;
            cursor: pointer;
            z-index: 5;
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
            <span class="brand-title">PreySON Studio</span>
        </div>
        <div class="nav-actions">
            <a href="/" class="btn-live" target="_blank">View Public Feed &nearr;</a>
            <form action="/logout" method="POST" style="display:inline;">
                @csrf
                <button type="submit" class="btn-logout">Sign Out</button>
            </form>
        </div>
    </nav>

    <div class="container">
        <h1 style="font-size: 2.2rem; font-weight: 900; margin-bottom: 1.5rem;">Manage Vault</h1>

        @if(session('success'))
            <div class="alert-success">{{ session('success') }}</div>
        @endif

        <div class="upload-card">
            <h2 style="margin-bottom: 1rem; font-weight: 800;">Upload Single or Batch (.ZIP)</h2>
            <form action="{{ route('posts.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="form-group">
                    <label for="title">Title / Caption (Optional)</label>
                    <input type="text" id="title" name="title" placeholder="Auto-generated from filename if empty">
                </div>
                <div class="form-group">
                    <label for="media">Select Media or .ZIP</label>
                    <input type="file" id="media" name="media" accept="image/*,video/mp4,video/webm,video/quicktime,.zip" required>
                </div>
                <button type="submit" class="btn-yellow">🚀 Upload to Vault</button>
            </form>
        </div>

        <form id="batchDeleteForm" action="{{ route('posts.batchDelete') }}" method="POST">
            @csrf
            @method('DELETE')

            <div class="batch-bar">
                <div>
                    <input type="checkbox" id="selectAll" onchange="toggleSelectAll(this)" style="width: 18px; height: 18px; accent-color: #7c3aed; vertical-align: middle;">
                    <label for="selectAll" style="font-weight: 800; margin-left: 0.5rem; cursor: pointer;">Select All (<span id="selectedCount">0</span> selected)</label>
                </div>
                <button type="submit" id="deleteBtn" class="btn-danger" disabled onclick="return confirm('Are you sure you want to delete the selected memes?')">
                    🗑️ Delete Selected
                </button>
            </div>

            <div class="grid-history">
                @foreach($posts as $post)
                    <div class="history-card">
                        <input type="checkbox" name="post_ids[]" value="{{ $post->id }}" class="post-checkbox" onchange="updateCount()">
                        @if($post->media_type === 'video')
                            <video src="{{ asset('storage/' . $post->media_path) }}"></video>
                        @else
                            <img src="{{ asset('storage/' . $post->media_path) }}" alt="{{ $post->title }}">
                        @endif
                        <p title="{{ $post->title }}">{{ $post->title }}</p>
                    </div>
                @endforeach
            </div>
        </form>
    </div>

    <script>
        function toggleSelectAll(master) {
            const checkboxes = document.querySelectorAll('.post-checkbox');
            checkboxes.forEach(cb => cb.checked = master.checked);
            updateCount();
        }

        function updateCount() {
            const checked = document.querySelectorAll('.post-checkbox:checked').length;
            document.getElementById('selectedCount').innerText = checked;
            document.getElementById('deleteBtn').disabled = checked === 0;
        }
    </script>

</body>
</html>