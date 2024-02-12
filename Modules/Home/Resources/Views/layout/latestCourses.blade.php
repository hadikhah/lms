<div class="box-filter">
    <div class="b-head">
        <h2>جدید ترین دوره ها</h2>
        <a href="all-courses.html">مشاهده همه</a>
    </div>
    <div class="posts">
        @isset($latestCourses)
            @foreach($latestCourses as $courseItem)
                @include('Home::layout.singleCourseBox')
            @endforeach
        @endisset
    </div>
</div>
