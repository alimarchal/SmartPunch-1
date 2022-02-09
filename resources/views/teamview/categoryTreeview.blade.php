<ul class="tree">
    @foreach($parentCategories as $category)
            <li>
                {{$category->name}}
        @if(count($category->subcategory))
            @include('teamview.subCategoryList',['subcategories' => $category->subcategory])
        @endif
            </li>
    @endforeach
</ul>
