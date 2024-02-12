@extends('Dashboard::master')
@section('breadcrumb')
    <li><a href="{{ route('categories.index') }}" title="{{__("categories")}}">{{__("categories")}}</a></li>
    <li><a href="#" title="{{__("edit category")}}">{{__("edit category")}}</a></li>
@endsection
@section('content')
    <div class="row no-gutters  ">
        <div class="col-6 bg-white">
            <p class="box__title">{{__("edit category")}}</p>
            <form action="{{ route('categories.update', $category->id) }}" method="post" class="padding-30">
                @csrf
                @method('patch')
                <input type="text" name="title" required placeholder="{{__("category name")}}" class="text"
                       value="{{ $category->title}}">
                <input type="text" name="slug" required placeholder="{{__("slug")}}" class="text"
                       value="{{ $category->slug}}">
                <p class="box__title margin-bottom-15">{{__("choose parent category")}}</p>
                <select name="parent_id" id="parent_id">
                    <option value="">{{__("none")}}</option>
                    @foreach($categories as $categoryItem)
                        <option value="{{ $categoryItem->id }}"
                                @if($categoryItem->id == $category->parent_id) selected @endif>{{ $categoryItem->title }}</option>
                    @endforeach
                </select>
                <button class="btn btn-info">{{__("update")}}</button>
            </form>
        </div>
    </div>
@endsection
