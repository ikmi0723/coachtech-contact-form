@extends('layouts.app')

@section('title', 'Admin')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/admin.css') }}">
@endsection

@section('content')
    <h1 class="admin-title">Admin</h1>

    {{-- 検索フォーム（1列） --}}
    <form class="admin-search" action="/search" method="get">
    <input
      class="admin-search__input"
      type="text"
      name="keyword"
      value="{{ request('keyword') }}"
      placeholder="名前やメールアドレスを入力してください"
    />

    <select class="admin-search__select" name="gender">
      <option value="" {{ request('gender') === null || request('gender') === '' ? 'selected' : '' }}>性別</option>
      <option value="all" {{ request('gender') === 'all' ? 'selected' : '' }}>全て</option>
      <option value="1" {{ request('gender') === '1' ? 'selected' : '' }}>男性</option>
      <option value="2" {{ request('gender') === '2' ? 'selected' : '' }}>女性</option>
      <option value="3" {{ request('gender') === '3' ? 'selected' : '' }}>その他</option>
    </select>

    <select class="admin-search__select" name="category_id">
      <option value="" {{ request('category_id') ? '' : 'selected' }}>お問い合わせの種類</option>
      @foreach ($categories as $category)
        <option value="{{ $category->id }}" {{ (string)request('category_id') === (string)$category->id ? 'selected' : '' }}>
          {{ $category->content }}
        </option>
      @endforeach
    </select>

    <input class="admin-search__date" type="date" name="date" value="{{ request('date') }}" />

    <button class="btn btn--primary" type="submit">検索</button>
    <a class="btn btn--gray" href="/reset">リセット</a>
  </form>

  {{-- 検索1列の下：左にexport、右にpagination --}}
  <div class="admin-toolbar">
    <div class="admin-toolbar__left">
        <a class="btn btn--outline"
            href="{{ url('/export') . (request()->getQueryString() ? '?' . request()->getQueryString() : '') }}">
            エクスポート
        </a>
    </div>
    <div class="admin-toolbar__right pagination">
        {{ $contacts->links('vendor.pagination.admin') }}
    </div>
  </div>

  {{-- 一覧 --}}
  <table class="admin-table">
    <thead>
      <tr>
        <th>お名前</th>
        <th>性別</th>
        <th>メールアドレス</th>
        <th>お問い合わせ内容</th>
      </tr>
    </thead>
    <tbody>
      @foreach ($contacts as $contact)
      <tr class="admin-table__row">
        <td>{{ $contact->last_name }} {{ $contact->first_name }}</td>
        <td>{{ $contact->gender_label }}</td>
        <td>{{ $contact->email }}</td>
        <td>
          <div class="admin-detail-cell">
            <span class="admin-detail-cell__text">{{ $contact->detail }}</span>

            <button
              type="button"
              class="btn btn--outline js-open-modal"
              data-id="{{ $contact->id }}"
              data-name="{{ $contact->last_name }} {{ $contact->first_name }}"
              data-gender="{{ $contact->gender_label }}"
              data-email="{{ $contact->email }}"
              data-tel="{{ $contact->tel }}"
              data-address="{{ $contact->address }}"
              data-building="{{ $contact->building }}"
              data-category="{{ $contact->category->content ?? '' }}"
              data-detail="{{ $contact->detail }}"
            >
              詳細
            </button>
          </div>
        </td>
      </tr>
    @endforeach
    </tbody>
  </table>

{{-- 詳細モーダル（1個だけ） --}}
<div class="modal js-modal" aria-hidden="true">
  <div class="modal__overlay js-close-modal"></div>

  <div class="modal__content" role="dialog" aria-modal="true">
    <button type="button" class="modal__close js-close-modal">×</button>

    <h2 class="modal__title">お問い合わせ詳細</h2>

    <div class="modal__body">
      <dl class="modal__list">
        <div class="modal__row"><dt>お名前</dt><dd class="js-modal-name"></dd></div>
        <div class="modal__row"><dt>性別</dt><dd class="js-modal-gender"></dd></div>
        <div class="modal__row"><dt>メールアドレス</dt><dd class="js-modal-email"></dd></div>
        <div class="modal__row"><dt>電話番号</dt><dd class="js-modal-tel"></dd></div>
        <div class="modal__row"><dt>住所</dt><dd class="js-modal-address"></dd></div>
        <div class="modal__row"><dt>建物名</dt><dd class="js-modal-building"></dd></div>
        <div class="modal__row"><dt>お問い合わせの種類</dt><dd class="js-modal-category"></dd></div>
        <div class="modal__row"><dt>お問い合わせ内容</dt><dd class="js-modal-detail"></dd></div>
      </dl>
    </div>

    {{-- モーダル最下部中央：削除ボタン --}}
    <div class="modal__footer">
      <form method="POST" class="js-delete-form" action="">
        @csrf
        @method('DELETE')
        <input type="hidden" name="redirect" class="js-redirect" value="">
        <button type="submit" class="btn btn--primary">削除</button>
      </form>
    </div>
  </div>
</div>

<script>
  const modal = document.querySelector('.js-modal');
  const openButtons = document.querySelectorAll('.js-open-modal');
  const closeButtons = document.querySelectorAll('.js-close-modal');

  const setText = (selector, value) => {
    const el = document.querySelector(selector);
    if (el) el.textContent = value ?? '';
  };

  const openModal = (btn) => {
    setText('.js-modal-name', btn.dataset.name);
    setText('.js-modal-gender', btn.dataset.gender);
    setText('.js-modal-email', btn.dataset.email);
    setText('.js-modal-tel', btn.dataset.tel);
    setText('.js-modal-address', btn.dataset.address);
    setText('.js-modal-building', btn.dataset.building);
    setText('.js-modal-category', btn.dataset.category);
    setText('.js-modal-detail', btn.dataset.detail);

    // 削除フォームの action を差し替える
    const form = document.querySelector('.js-delete-form');
    form.action = `/delete/${btn.dataset.id}`;

    const redirectInput = document.querySelector('.js-redirect');
    redirectInput.value = window.location.pathname + window.location.search;

    modal.classList.add('is-open');
    modal.setAttribute('aria-hidden', 'false');
  };

  const closeModal = () => {
    modal.classList.remove('is-open');
    modal.setAttribute('aria-hidden', 'true');
  };

  openButtons.forEach((btn) => {
    btn.addEventListener('click', () => openModal(btn));
  });

  closeButtons.forEach((btn) => {
    btn.addEventListener('click', closeModal);
  });

  // Escで閉じる（地味に便利＆自然）
  document.addEventListener('keydown', (e) => {
    if (e.key === 'Escape' && modal.classList.contains('is-open')) {
      closeModal();
    }
  });
</script>
@endsection