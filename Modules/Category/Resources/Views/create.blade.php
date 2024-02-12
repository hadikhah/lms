<p class="box__title">{{__("create new category")}}</p>
<form action="{{ route('categories.store') }}" method="post" class="padding-30">
    @csrf
    <input type="text" name="title" required placeholder="{{__("category name")}}" class="text">
    <input type="text" name="slug" required placeholder="{{__("slug")}}" class="text">
    <p class="box__title margin-bottom-15">{{__("choose parent category")}}</p>
    <select name="parent_id" id="parent_id">
        <option value="">{{__("none")}}</option>
        @foreach($categories as $category)
            <option value="{{ $category->id }}">{{ $category->title }}</option>
        @endforeach
    </select>
    <button class="btn btn-info">{{__("Add")}}</button>
</form>
