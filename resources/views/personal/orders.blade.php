@extends('layouts.app')

@section('title', 'Мои заказы')

@section('content')
<main class="py-16 lg:py-20">
    <div class="container">

        <!-- Breadcrumbs -->
        <ul class="breadcrumbs flex flex-wrap gap-y-1 gap-x-4 mb-6">
            <li><a href="{{ route('home') }}" class="text-body hover:text-pink text-xs">Главная</a></li>
            <li><span class="text-body text-xs">Мои заказы</span></li>
        </ul>

        <section>
            <h1 class="mb-8 text-lg lg:text-[42px] font-black">Мои заказы</h1>
            <div class="w-full space-y-4 text-white text-sm text-left">
                @if($orders->isEmpty())
                    <!-- Message -->
                    <div class="py-3 px-6 rounded-lg bg-pink text-white">Нет заказов</div>
                @else
                    @each('personal.shared.order-item', $orders, 'order')
                @endif
            </div>
        </section>
        <div class="mt-12">
            {{ $orders->links() }}
        </div>
    </div>
</main>
@endsection
