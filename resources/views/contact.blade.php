@extends('base')
@section('title', 'Контакты — Inertlab')
@section('content')
<section class="pt-12 sm:pt-16">
  <div class="mx-auto max-w-5xl px-4 sm:px-6 lg:px-8">
    <h1 class="text-3xl sm:text-4xl font-bold">Свяжитесь с нами</h1>
    <p class="text-white/70 mt-2">Опишите задачу — мы предложим подходящую линейку IMU и сроки поставки.</p>

    <div class="mt-8 grid md:grid-cols-2 gap-6">
      <form method="POST" action="{{ route('contact.send') }}" class="rounded-2xl border border-white/10 bg-white/5 p-6">
        @csrf
        @if(session('success'))
          <div class="mb-4 p-3 rounded-lg bg-green-500/20 border border-green-500/50 text-green-300 text-sm">
            {{ session('success') }}
          </div>
        @endif
        @if(session('error'))
          <div class="mb-4 p-3 rounded-lg bg-red-500/20 border border-red-500/50 text-red-300 text-sm">
            {{ session('error') }}
          </div>
        @endif
        @if($errors->any())
          <div class="mb-4 p-3 rounded-lg bg-red-500/20 border border-red-500/50 text-red-300 text-sm">
            <ul>
              @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
              @endforeach
            </ul>
          </div>
        @endif
        <div class="grid grid-cols-1 gap-4">
          <div>
            <label class="text-sm text-white/70">Имя</label>
            <input name="name" value="{{ old('name') }}" required class="mt-1 w-full rounded-lg bg-black/40 border border-white/10 px-3 py-2 outline-none focus:border-ink-400 text-white" placeholder="Иван"/>
          </div>
          <div>
            <label class="text-sm text-white/70">Email</label>
            <input type="email" name="email" value="{{ old('email') }}" required class="mt-1 w-full rounded-lg bg-black/40 border border-white/10 px-3 py-2 outline-none focus:border-ink-400 text-white" placeholder="you@company.ru"/>
          </div>
          <div>
            <label class="text-sm text-white/70">Сообщение</label>
            <textarea name="message" rows="5" required class="mt-1 w-full rounded-lg bg-black/40 border border-white/10 px-3 py-2 outline-none focus:border-ink-400 text-white" placeholder="Опишите проект, требования к IMU…">{{ old('message') }}</textarea>
          </div>
          <button type="submit" class="mt-2 inline-flex items-center justify-center rounded-lg bg-ink-500 hover:bg-ink-600 px-4 py-2 shadow-glow transition">Отправить</button>
        </div>
      </form>

      <div class="rounded-2xl border border-white/10 bg-white/5 p-6">
        <h2 class="text-lg font-semibold">Контакты</h2>
        <p class="text-white/70 mt-2 text-sm">info.inertlab@gmail.com</p>
        <div class="mt-6 overflow-hidden rounded-lg">
          <iframe class="w-full h-64" src="https://yandex.ru/map-widget/v1/?ll=37.6173%2C55.7558&z=12" frameborder="0" allowfullscreen="true"></iframe>
        </div>
      </div>
    </div>
  </div>
</section>
@endsection




