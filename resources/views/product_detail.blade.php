@extends('base')
@section('title', $product['name'] . ' — ' . $product['series'] . ' | Inertlab')
@section('content')
<section class="pt-10 sm:pt-14">
  <div class="mx-auto max-w-6xl px-4 sm:px-6 lg:px-8">
    <div class="text-sm text-white/60 mb-4"><a class="hover:text-white" href="{{ route('products') }}">← Назад к каталогу</a></div>

    <div class="grid lg:grid-cols-2 gap-8">
      <!-- Gallery -->
      <div>
        <div class="swiper rounded-2xl overflow-hidden border border-white/10 bg-white/5">
          <div class="swiper-wrapper">
            @if(isset($product['model3d']) && $product['model3d'])
            <div class="swiper-slide">
              <div class="w-full h-[420px] bg-black/20 flex items-center justify-center">
                <model-viewer 
                  src="{{ asset('models/' . $product['model3d']) }}"
                  alt="{{ $product['name'] }} 3D модель"
                  camera-controls
                  auto-rotate
                  auto-rotate-delay="1000"
                  interaction-policy="allow-when-focused"
                  style="width: 100%; height: 100%; background: transparent;"
                  loading="eager">
                  <div slot="poster" class="w-full h-full flex items-center justify-center bg-black/40">
                    <div class="text-white/60 text-sm">Загрузка 3D модели...</div>
                  </div>
                </model-viewer>
              </div>
            </div>
            @endif
            @foreach($product['images'] as $img)
            <div class="swiper-slide">
              <img src="{{ asset(ltrim($img, '/')) }}" class="w-full h-[420px] object-cover" alt="{{ $product['name'] }}" />
            </div>
            @endforeach
          </div>
          <div class="swiper-pagination"></div>
          <div class="swiper-button-prev"></div>
          <div class="swiper-button-next"></div>
        </div>
      </div>

      <!-- Summary -->
      <div>
        <div class="text-xs text-ink-300">{{ $product['series'] }}</div>
        <h1 class="text-3xl font-bold mt-1">{{ $product['name'] }}</h1>
        <p class="text-white/70 mt-3">{{ $product['tagline'] }}</p>

        <div class="mt-6 flex gap-3">
          <a href="{{ asset('datasheets/' . $product['datasheet']) }}" download class="inline-flex items-center gap-2 px-4 py-2 rounded-lg bg-ink-500 hover:bg-ink-600 shadow-glow">Скачать даташит</a>
          <a href="{{ route('contact') }}" class="inline-flex items-center gap-2 px-4 py-2 rounded-lg border border-white/10 hover:border-white/20 bg-white/5 hover:bg-white/10">Запросить цену</a>
        </div>

        <!-- Specs Table -->
        <div class="mt-8 rounded-2xl border border-white/10 bg-white/5 overflow-hidden">
          <table class="w-full text-sm">
            <tbody>
              @foreach($product['specs'] as $key => $value)
              <tr class="border-b border-white/10">
                <td class="px-4 py-3 text-white/70 w-1/2">{{ $key }}</td>
                <td class="px-4 py-3">{{ $value }}</td>
              </tr>
              @endforeach
            </tbody>
          </table>
        </div>
      </div>
    </div>

    <!-- Bottom CTA -->
    <div class="mt-10 rounded-2xl border border-white/10 bg-gradient-to-r from-ink-600 to-ink-500 p-6 flex items-center justify-between gap-4 flex-col sm:flex-row">
      <div>
        <div class="text-lg font-semibold">Нужны образцы или консультация по интеграции?</div>
        <div class="text-white/80 text-sm">Поможем подобрать IMU и предоставим рекомендации по фильтрации.</div>
      </div>
      <a href="{{ route('contact') }}" class="inline-flex items-center gap-2 px-4 py-2 rounded-lg bg-white text-night font-medium hover:bg-white/90">Связаться</a>
    </div>
  </div>
</section>

<script>
  document.addEventListener('DOMContentLoaded', () => {
    if (window.Swiper) {
      new Swiper('.swiper', {
        loop: true,
        pagination: { el: '.swiper-pagination', clickable: true },
        navigation: { nextEl: '.swiper-button-next', prevEl: '.swiper-button-prev' },
      });
    }
  });
</script>
@endsection




