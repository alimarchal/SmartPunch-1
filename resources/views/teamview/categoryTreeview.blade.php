<ul>
    @foreach($parentCategories as $category)


       <li> {{$category->name}}</li>

        @if(count($category->subcategory))
            @include('teamview.subCategoryList',['subcategories' => $category->subcategory])
        @endif

    @endforeach
</ul>
