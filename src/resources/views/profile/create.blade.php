@extends('layouts.common')

@section('style')
<link rel="stylesheet" href="{{ asset('css/create.css') }}">
@endsection

@section('content')
<div class="profile-container">
    <div class="profile-card">
        <h2 class="profile-title">プロフィール登録</h2>
        <p class="profile-subtitle">サービスを利用するために、追加情報を入力してください。</p>

        <form action="{{ route('profile.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="form-group">
                <label class="form-label">性別</label>
                <div class="radio-group">
                    <label class="radio-label">
                        <input type="radio" name="gender" value="男性" {{ old('gender') == '男性' ? 'checked' : '' }}>
                        <span>男性</span>
                    </label>
                    <label class="radio-label">
                        <input type="radio" name="gender" value="女性" {{ old('gender') == '女性' ? 'checked' : '' }}>
                        <span>女性</span>
                    </label>
                    <label class="radio-label">
                        <input type="radio" name="gender" value="その他" {{ old('gender') == 'その他' ? 'checked' : '' }}>
                        <span>その他</span>
                    </label>
                </div>
                @error('gender')
                <p class="error-text">{{ $message }}</p>
                @enderror
            </div>

            <div class="form-group">
                <label for="birthday" class="form-label">誕生日</label>
                <input type="date" name="birthday" id="birthday" value="{{ old('birthday') }}" class="form-input">
                @error('birthday')
                <p class="error-text">{{ $message }}</p>
                @enderror
            </div>

            <div class="form-group">
                <label for="image" class="form-label">プロフィール画像</label>

                <div class="image-preview-container" style="margin-bottom: 15px;">
                    <img id="preview" src="{{ asset('img/default-avatar.png') }}" alt="プレビュー"
                        style="width: 120px; height: 120px; border-radius: 50%; object-fit: cover; border: 3px solid #fde68a; display: none;">
                </div>

                <input type="file" name="image" id="image-input" class="form-file" accept="image/*" onchange="previewImage(this)">

                @error('image')
                <p class="error-text">{{ $message }}</p>
                @enderror
            </div>

            <div class="form-actions">
                <button type="submit" class="submit-button">
                    登録を完了する
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
<script>
    function previewImage(input) {
        const preview = document.getElementById('preview');

        if (input.files && input.files[0]) {
            const reader = new FileReader();

            reader.onload = function(e) {
                preview.src = e.target.result;
                preview.style.display = 'block'; // 画像が読み込まれたら表示する
            }

            reader.readAsDataURL(input.files[0]); // ファイルを読み込む
        }
    }
</script>