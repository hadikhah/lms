@extends('Dashboard::master')
@section('breadcrumb')
    <li><a href="{{ route('categories.index') }}" title="{{__("categories")}}">{{__("categories")}}</a></li>
@endsection
@section('content')
    <div class="row no-gutters  ">
        <div class="col-8 margin-left-10 margin-bottom-15 border-radius-3">
            <p class="box__title">{{__('categories')}}</p>
            <div class="table__box">
                <table class="table">
                    <thead role="rowgroup">
                    <tr role="row" class="title-row">
                        <th>{{__("id")}}</th>
                        <th>{{__("category name")}}</th>
                        <th>{{__("slug")}}</th>
                        <th>{{__("parent category")}}</th>
                        <th>{{__("process")}}</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($categories as $category)
                        <tr role="row" class="">
                            <td><a href="">{{ $category->id }}</a></td>
                            <td><a href="">{{ $category->title }}</a></td>
                            <td>{{ $category->slug }}</td>
                            <td>{{ $category->parent }}</td>
                            <td>
                                <a href=""
                                   onclick="deleteItem(event, '{{ route('categories.destroy', $category->id) }}')"
                                   class="item-delete mlg-15" title="{{__("delete")}}"></a>
                                <a href="" target="_blank" class="item-eye mlg-15" title="{{__("view")}}"></a>
                                <a href="{{ route('categories.edit',  $category->id) }}" class="item-edit "
                                   title="{{__("edit")}}"></a>
                            </td>
                        </tr>
                    @endforeach

                    </tbody>
                </table>
            </div>
        </div>
        <div class="col-4 bg-white">
            @include('Categories::create')
        </div>
    </div>
@endsection
