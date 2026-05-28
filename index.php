<?php
// ============================
// ふるさと納税 検索システム 雛形
// 作成者：[あなたの名前]
// 使用技術：PHP / JavaScript / HTML / CSS
// ============================

// サンプルデータ（本来はDBから取得）
$donations = [
    [
        "id" => 1,
        "city" => "鳥取県米子市",
        "name" => "大山どり 鶏もも肉 2kg",
        "category" => "肉類",
        "amount" => 10000,
        "point" => 100,
        "image" => "https://placehold.co/300x200/2d6a4f/ffffff?text=大山どり",
        "description" => "鳥取県が誇るブランド鶏「大山どり」。柔らかくジューシーな鶏もも肉2kgをお届けします。"
    ],
    [
        "id" => 2,
        "city" => "鳥取県境港市",
        "name" => "境港産 松葉ガニ 2杯",
        "category" => "魚介類",
        "amount" => 30000,
        "point" => 300,
        "image" => "https://placehold.co/300x200/1a6894/ffffff?text=松葉ガニ",
        "description" => "日本海の荒波で育った新鮮な松葉ガニ。冬の味覚をご自宅でお楽しみください。"
    ],
    [
        "id" => 3,
        "city" => "鳥取県倉吉市",
        "name" => "鳥取県産 二十世紀梨 5kg",
        "category" => "果物",
        "amount" => 8000,
        "point" => 80,
        "image" => "https://placehold.co/300x200/74b72e/ffffff?text=二十世紀梨",
        "description" => "鳥取を代表する特産品。みずみずしく甘い二十世紀梨を厳選してお届けします。"
    ],
    [
        "id" => 4,
        "city" => "鳥取県米子市",
        "name" => "大山乳業 チーズ詰め合わせ",
        "category" => "乳製品",
        "amount" => 12000,
        "point" => 120,
        "image" => "https://placehold.co/300x200/e9c46a/333333?text=チーズ",
        "description" => "大山の麓で育てられた牛から作られる濃厚チーズ。4種類のチーズをセットでお届けします。"
    ],
    [
        "id" => 5,
        "city" => "鳥取県岩美町",
        "name" => "岩美町産 松葉ガニ お試しセット",
        "category" => "魚介類",
        "amount" => 15000,
        "point" => 150,
        "image" => "https://placehold.co/300x200/023e8a/ffffff?text=カニセット",
        "description" => "初めての方にも安心のお試しセット。新鮮な松葉ガニを手軽に楽しめます。"
    ],
    [
        "id" => 6,
        "city" => "鳥取県湯梨浜町",
        "name" => "はわい温泉 宿泊ペアチケット",
        "category" => "体験・宿泊",
        "amount" => 50000,
        "point" => 500,
        "image" => "https://placehold.co/300x200/8338ec/ffffff?text=温泉宿泊",
        "description" => "東郷池のほとりに佇む温泉宿。絶景と湯を楽しむペアプランです。"
    ],
];

// 検索・フィルター処理（PHP側）
$keyword  = isset($_GET['keyword'])  ? htmlspecialchars($_GET['keyword'])  : '';
$category = isset($_GET['category']) ? htmlspecialchars($_GET['category']) : '';
$max_amt  = isset($_GET['max_amt'])  ? (int)$_GET['max_amt']              : 0;

$filtered = array_filter($donations, function($item) use ($keyword, $category, $max_amt) {
    if ($keyword && strpos($item['name'] . $item['city'] . $item['description'], $keyword) === false) return false;
    if ($category && $item['category'] !== $category) return false;
    if ($max_amt > 0 && $item['amount'] > $max_amt) return false;
    return true;
});

$categories = array_unique(array_column($donations, 'category'));
$result_count = count($filtered);
?>
<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ふるさと納税 検索システム</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Noto+Serif+JP:wght@400;700&family=Noto+Sans+JP:wght@300;400;600&display=swap" rel="stylesheet">
    <style>
        /* ========== CSS変数 ========== */
        :root {
            --green-dark:  #1b4332;
            --green-mid:   #2d6a4f;
            --green-light: #52b788;
            --accent:      #e76f51;
            --sand:        #fdf8f0;
            --text:        #1a1a2e;
            --muted:       #6b7280;
            --white:       #ffffff;
            --shadow:      0 4px 24px rgba(0,0,0,0.08);
            --radius:      12px;
        }

        * { margin: 0; padding: 0; box-sizing: border-box; }

        body {
            font-family: 'Noto Sans JP', sans-serif;
            background: var(--sand);
            color: var(--text);
            min-height: 100vh;
        }

        /* ========== ヘッダー ========== */
        header {
            background: linear-gradient(135deg, var(--green-dark) 0%, var(--green-mid) 100%);
            color: var(--white);
            padding: 0;
            position: sticky;
            top: 0;
            z-index: 100;
            box-shadow: 0 2px 12px rgba(0,0,0,0.2);
        }
        .header-inner {
            max-width: 1100px;
            margin: 0 auto;
            padding: 18px 24px;
            display: flex;
            align-items: center;
            gap: 16px;
        }
        .header-logo {
            font-family: 'Noto Serif JP', serif;
            font-size: 1.4rem;
            font-weight: 700;
            letter-spacing: 0.05em;
        }
        .header-logo span {
            color: var(--green-light);
        }
        .header-sub {
            font-size: 0.75rem;
            opacity: 0.7;
            margin-left: auto;
        }

        /* ========== ヒーロー ========== */
        .hero {
            background: linear-gradient(160deg, var(--green-dark) 0%, var(--green-mid) 60%, var(--green-light) 100%);
            color: var(--white);
            padding: 56px 24px 80px;
            text-align: center;
            position: relative;
            overflow: hidden;
        }
        .hero::before {
            content: '';
            position: absolute;
            inset: 0;
            background: url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' fill-rule='evenodd'%3E%3Cg fill='%23ffffff' fill-opacity='0.04'%3E%3Cpath d='M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E");
        }
        .hero h1 {
            font-family: 'Noto Serif JP', serif;
            font-size: clamp(1.6rem, 4vw, 2.4rem);
            font-weight: 700;
            margin-bottom: 12px;
            position: relative;
        }
        .hero p {
            font-size: 0.95rem;
            opacity: 0.85;
            position: relative;
        }

        /* ========== 検索フォーム ========== */
        .search-card {
            max-width: 900px;
            margin: -36px auto 0;
            background: var(--white);
            border-radius: var(--radius);
            box-shadow: var(--shadow);
            padding: 28px 32px;
            position: relative;
            z-index: 10;
        }
        .search-card h2 {
            font-size: 0.85rem;
            font-weight: 600;
            color: var(--green-mid);
            text-transform: uppercase;
            letter-spacing: 0.1em;
            margin-bottom: 16px;
        }
        .search-grid {
            display: grid;
            grid-template-columns: 1fr 160px 180px auto;
            gap: 12px;
            align-items: end;
        }
        .form-group label {
            display: block;
            font-size: 0.78rem;
            color: var(--muted);
            margin-bottom: 6px;
            font-weight: 600;
        }
        .form-group input,
        .form-group select {
            width: 100%;
            padding: 10px 14px;
            border: 2px solid #e5e7eb;
            border-radius: 8px;
            font-size: 0.9rem;
            font-family: inherit;
            transition: border-color 0.2s;
            background: var(--sand);
        }
        .form-group input:focus,
        .form-group select:focus {
            outline: none;
            border-color: var(--green-light);
            background: var(--white);
        }
        .btn-search {
            background: var(--accent);
            color: var(--white);
            border: none;
            padding: 11px 28px;
            border-radius: 8px;
            font-size: 0.95rem;
            font-weight: 600;
            font-family: inherit;
            cursor: pointer;
            transition: transform 0.15s, box-shadow 0.15s;
            white-space: nowrap;
        }
        .btn-search:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 16px rgba(231,111,81,0.35);
        }
        .btn-reset {
            background: none;
            border: 2px solid #e5e7eb;
            color: var(--muted);
            padding: 9px 16px;
            border-radius: 8px;
            font-size: 0.85rem;
            font-family: inherit;
            cursor: pointer;
            margin-left: 8px;
        }

        /* ========== メインコンテンツ ========== */
        main {
            max-width: 1100px;
            margin: 40px auto;
            padding: 0 24px;
        }
        .result-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 24px;
        }
        .result-count {
            font-size: 0.9rem;
            color: var(--muted);
        }
        .result-count strong {
            color: var(--green-mid);
            font-size: 1.2rem;
        }
        .sort-select {
            padding: 7px 12px;
            border: 2px solid #e5e7eb;
            border-radius: 8px;
            font-size: 0.85rem;
            font-family: inherit;
            background: var(--white);
            cursor: pointer;
        }

        /* ========== カードグリッド ========== */
        .card-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
            gap: 24px;
        }
        .card {
            background: var(--white);
            border-radius: var(--radius);
            box-shadow: var(--shadow);
            overflow: hidden;
            transition: transform 0.2s, box-shadow 0.2s;
            cursor: pointer;
        }
        .card:hover {
            transform: translateY(-4px);
            box-shadow: 0 12px 36px rgba(0,0,0,0.12);
        }
        .card-img {
            width: 100%;
            height: 180px;
            object-fit: cover;
            display: block;
        }
        .card-body {
            padding: 18px 20px;
        }
        .card-meta {
            display: flex;
            align-items: center;
            gap: 8px;
            margin-bottom: 8px;
        }
        .badge {
            background: #e8f5e9;
            color: var(--green-mid);
            font-size: 0.72rem;
            font-weight: 600;
            padding: 3px 10px;
            border-radius: 20px;
        }
        .card-city {
            font-size: 0.75rem;
            color: var(--muted);
        }
        .card-name {
            font-family: 'Noto Serif JP', serif;
            font-size: 1rem;
            font-weight: 700;
            margin-bottom: 8px;
            line-height: 1.5;
        }
        .card-desc {
            font-size: 0.82rem;
            color: var(--muted);
            line-height: 1.7;
            margin-bottom: 14px;
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }
        .card-footer {
            display: flex;
            align-items: center;
            justify-content: space-between;
            border-top: 1px solid #f3f4f6;
            padding-top: 12px;
        }
        .card-amount {
            font-size: 1.15rem;
            font-weight: 700;
            color: var(--accent);
        }
        .card-amount span {
            font-size: 0.75rem;
            color: var(--muted);
            font-weight: 400;
        }
        .btn-detail {
            background: var(--green-mid);
            color: var(--white);
            border: none;
            padding: 7px 16px;
            border-radius: 6px;
            font-size: 0.8rem;
            font-family: inherit;
            cursor: pointer;
            transition: background 0.2s;
        }
        .btn-detail:hover { background: var(--green-dark); }

        /* ========== 件数0件 ========== */
        .no-result {
            text-align: center;
            padding: 80px 20px;
            color: var(--muted);
        }
        .no-result .icon { font-size: 3rem; margin-bottom: 16px; }
        .no-result p { font-size: 1rem; }

        /* ========== モーダル ========== */
        .modal-overlay {
            display: none;
            position: fixed;
            inset: 0;
            background: rgba(0,0,0,0.5);
            z-index: 1000;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }
        .modal-overlay.active { display: flex; }
        .modal {
            background: var(--white);
            border-radius: var(--radius);
            max-width: 560px;
            width: 100%;
            overflow: hidden;
            animation: slideUp 0.25s ease;
        }
        @keyframes slideUp {
            from { opacity: 0; transform: translateY(30px); }
            to   { opacity: 1; transform: translateY(0); }
        }
        .modal img {
            width: 100%;
            height: 220px;
            object-fit: cover;
        }
        .modal-body { padding: 24px; }
        .modal-body h3 {
            font-family: 'Noto Serif JP', serif;
            font-size: 1.2rem;
            margin-bottom: 8px;
        }
        .modal-body .modal-city {
            font-size: 0.8rem;
            color: var(--muted);
            margin-bottom: 14px;
        }
        .modal-body .modal-desc {
            font-size: 0.9rem;
            line-height: 1.8;
            color: #4b5563;
            margin-bottom: 20px;
        }
        .modal-footer {
            display: flex;
            align-items: center;
            justify-content: space-between;
        }
        .modal-amount {
            font-size: 1.4rem;
            font-weight: 700;
            color: var(--accent);
        }
        .btn-close {
            background: #f3f4f6;
            border: none;
            padding: 10px 20px;
            border-radius: 8px;
            font-size: 0.9rem;
            font-family: inherit;
            cursor: pointer;
        }
        .btn-apply {
            background: var(--accent);
            color: var(--white);
            border: none;
            padding: 10px 24px;
            border-radius: 8px;
            font-size: 0.9rem;
            font-weight: 600;
            font-family: inherit;
            cursor: pointer;
        }

        /* ========== フッター ========== */
        footer {
            text-align: center;
            padding: 40px 20px;
            font-size: 0.8rem;
            color: var(--muted);
            border-top: 1px solid #e5e7eb;
            margin-top: 60px;
        }

        /* ========== レスポンシブ ========== */
        @media (max-width: 700px) {
            .search-grid {
                grid-template-columns: 1fr 1fr;
            }
            .btn-search { grid-column: span 2; }
        }
    </style>
</head>
<body>

<!-- ヘッダー -->
<header>
    <div class="header-inner">
        <div class="header-logo">ふるさと<span>納税</span>サーチ</div>
        <div class="header-sub">全国自治体の返礼品を検索できます</div>
    </div>
</header>

<!-- ヒーロー -->
<section class="hero">
    <h1>あなたのふるさとを、もっと身近に。</h1>
    <p>全国の返礼品をキーワード・カテゴリー・寄附金額で簡単検索</p>
</section>

<!-- 検索フォーム -->
<div style="max-width:900px; margin:0 auto; padding:0 24px;">
    <div class="search-card">
        <h2>🔍 返礼品を検索する</h2>
        <form method="GET" action="">
            <div class="search-grid">
                <div class="form-group">
                    <label>キーワード</label>
                    <input type="text" name="keyword" placeholder="例：カニ、梨、米子" value="<?= $keyword ?>">
                </div>
                <div class="form-group">
                    <label>カテゴリー</label>
                    <select name="category">
                        <option value="">すべて</option>
                        <?php foreach ($categories as $cat): ?>
                        <option value="<?= $cat ?>" <?= $category === $cat ? 'selected' : '' ?>><?= $cat ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="form-group">
                    <label>寄附金額（上限）</label>
                    <select name="max_amt">
                        <option value="0">上限なし</option>
                        <option value="10000" <?= $max_amt === 10000 ? 'selected' : '' ?>>〜1万円</option>
                        <option value="20000" <?= $max_amt === 20000 ? 'selected' : '' ?>>〜2万円</option>
                        <option value="30000" <?= $max_amt === 30000 ? 'selected' : '' ?>>〜3万円</option>
                        <option value="50000" <?= $max_amt === 50000 ? 'selected' : '' ?>>〜5万円</option>
                    </select>
                </div>
                <div style="display:flex; align-items:flex-end; gap:8px;">
                    <button type="submit" class="btn-search">検索</button>
                    <a href="index.php"><button type="button" class="btn-reset">リセット</button></a>
                </div>
            </div>
        </form>
    </div>
</div>

<!-- メインコンテンツ -->
<main>
    <div class="result-header">
        <div class="result-count">
            <strong><?= $result_count ?></strong> 件の返礼品が見つかりました
        </div>
        <select class="sort-select" id="sortSelect" onchange="sortCards(this.value)">
            <option value="default">並び替え：標準</option>
            <option value="asc">寄附金額：安い順</option>
            <option value="desc">寄附金額：高い順</option>
        </select>
    </div>

    <?php if ($result_count === 0): ?>
    <div class="no-result">
        <div class="icon">🔍</div>
        <p>該当する返礼品が見つかりませんでした。<br>キーワードを変えてお試しください。</p>
    </div>
    <?php else: ?>
    <div class="card-grid" id="cardGrid">
        <?php foreach ($filtered as $item): ?>
        <div class="card" data-amount="<?= $item['amount'] ?>"
             onclick="openModal(<?= $item['id'] ?>)">
            <img class="card-img" src="<?= $item['image'] ?>" alt="<?= $item['name'] ?>">
            <div class="card-body">
                <div class="card-meta">
                    <span class="badge"><?= $item['category'] ?></span>
                    <span class="card-city"><?= $item['city'] ?></span>
                </div>
                <div class="card-name"><?= $item['name'] ?></div>
                <div class="card-desc"><?= $item['description'] ?></div>
                <div class="card-footer">
                    <div class="card-amount">
                        ¥<?= number_format($item['amount']) ?>
                        <span>（寄附金額）</span>
                    </div>
                    <button class="btn-detail" onclick="event.stopPropagation(); openModal(<?= $item['id'] ?>)">
                        詳細を見る
                    </button>
                </div>
            </div>
        </div>
        <?php endforeach; ?>
    </div>
    <?php endif; ?>
</main>

<!-- モーダル -->
<div class="modal-overlay" id="modalOverlay" onclick="closeModal(event)">
    <div class="modal" id="modalContent">
        <img id="modalImg" src="" alt="">
        <div class="modal-body">
            <div class="modal-city" id="modalCity"></div>
            <h3 id="modalName"></h3>
            <p class="modal-desc" id="modalDesc"></p>
            <div class="modal-footer">
                <div class="modal-amount" id="modalAmount"></div>
                <div style="display:flex; gap:10px;">
                    <button class="btn-close" onclick="document.getElementById('modalOverlay').classList.remove('active')">閉じる</button>
                    <button class="btn-apply" onclick="alert('申し込み機能は開発中です')">申し込む</button>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- フッター -->
<footer>
    <p>ふるさと納税サーチ ― 株式会社エッグ 技術検証用サンプル</p>
    <p style="margin-top:6px;">PHP / JavaScript / HTML で構築</p>
</footer>

<!-- JavaScript -->
<script>
    // サンプルデータ（PHP から JS へ渡す）
    const donations = <?= json_encode(array_values($donations)) ?>;

    // モーダルを開く
    function openModal(id) {
        const item = donations.find(d => d.id === id);
        if (!item) return;
        document.getElementById('modalImg').src    = item.image;
        document.getElementById('modalImg').alt    = item.name;
        document.getElementById('modalCity').textContent   = item.city;
        document.getElementById('modalName').textContent   = item.name;
        document.getElementById('modalDesc').textContent   = item.description;
        document.getElementById('modalAmount').textContent = '¥' + item.amount.toLocaleString() + '（寄附金額）';
        document.getElementById('modalOverlay').classList.add('active');
    }

    // モーダルを閉じる（背景クリック）
    function closeModal(e) {
        if (e.target === document.getElementById('modalOverlay')) {
            document.getElementById('modalOverlay').classList.remove('active');
        }
    }

    // ESCキーでモーダルを閉じる
    document.addEventListener('keydown', e => {
        if (e.key === 'Escape') document.getElementById('modalOverlay').classList.remove('active');
    });

    // カードをJS側でソートする
    function sortCards(order) {
        const grid = document.getElementById('cardGrid');
        if (!grid) return;
        const cards = Array.from(grid.querySelectorAll('.card'));
        cards.sort((a, b) => {
            const aAmt = parseInt(a.dataset.amount);
            const bAmt = parseInt(b.dataset.amount);
            if (order === 'asc')  return aAmt - bAmt;
            if (order === 'desc') return bAmt - aAmt;
            return 0;
        });
        cards.forEach(c => grid.appendChild(c));
    }
</script>

</body>
</html>
