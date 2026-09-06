@php
    /**
     * @var \Illuminate\Pagination\LengthAwarePaginator<int, \App\Models\Task> $tasks
     * @var \Illuminate\Database\Eloquent\Collection<int, \App\Models\Category> $categories
     * @var array{categories: array<string>|null} $filters
     */
@endphp

@extends('layouts.app')

@section('content')
    <div class="left-column">
        <h3 class="head-main head-task">Новые задания</h3>
        @foreach($tasks as $task)
            <div class="task-card">
                <div class="header-task">
                    <a  href="#" class="link link--block link--big">{{ $task->title }}</a>
                    <p class="price price--task">{{ $task->price }} ₽</p>
                </div>
            </div>
            <p class="info-text"><span class="current-time">4 часа </span>назад</p>
            <p class="task-text">{{ $task->description }}</p>
            <div class="footer-task">
                <p class="info-text town-text">{{ $task->city->name }}</p>
                <p class="info-text category-text">Переводы</p>
                <a href="#" class="button button--black">Смотреть Задание</a>
            </div>
        @endforeach
        @if($tasks->hasPages())
        <div class="pagination-wrapper">
            <ul class="pagination-list">
                <li class="pagination-item mark">
                    <a href="{{ $tasks->previousPageUrl() }}" class="link link--page"></a>
                </li>
                @foreach($tasks->getUrlRange(1, $tasks->lastPage()) as $page => $url)
                    <li class="pagination-item @if($page == $tasks->currentPage()) pagination-item--active @endif">
                        <a href="{{ $url }}" class="link link--page">{{ $page }}</a>
                    </li>
                @endforeach
                <li class="pagination-item mark">
                    <a href="{{ $tasks->nextPageUrl() }}" class="link link--page"></a>
                </li>
            </ul>
        </div>
        @endif
    </div>
    <div class="right-column">
        <div class="right-card black">
            <div class="search-form">
                <form action="{{ route('index') }}" method="get">
                    @csrf
                    <h4 class="head-card">Категории</h4>
                    <div class="form-group">
                        <div class="checkbox-wrapper">
                            @foreach($categories as $category)
                                <label class="control-label" for="{{ $category->icon }}_id">
                                    <input type="checkbox" name="categories[]" id="{{ $category->icon }}_id"
                                           value="{{ $category->name }}"
                                           @if(is_array($filters['categories']) && in_array($category->name, $filters['categories'])) checked @endif>
                                    {{ $category->name }}</label>
                            @endforeach
                        </div>
                    </div>
                    <h4 class="head-card">Дополнительно</h4>
                    <div class="form-group">
                        <label class="control-label" for="without-performer">
                            <input id="without-performer" type="checkbox" checked>
                            Без исполнителя</label>
                    </div>
                    <h4 class="head-card">Период</h4>
                    <div class="form-group">
                        <label for="period-value"></label>
                        <select id="period-value">
                            <option>1 час</option>
                            <option>12 часов</option>
                            <option>24 часа</option>
                        </select>
                    </div>
                    <input type="submit" class="button button--blue" value="Искать">
                </form>
            </div>
        </div>
    </div>
@endsection
