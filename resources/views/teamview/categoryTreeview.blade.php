<ul class="tree" >
    @foreach($parentCategories as $category)
            <li>
                <a href="#" style="color: blue; "> {{$category->name}}
                     - <span style="color: black;">Designation:</span>
                    <span style="color: red;">{{$category->designation}}</span>
                    @if(!empty($category->office))
                        - <span style="color: green;">Office: {{$category->office->name}}</span>
                    @endif

                    </a>
        @if(count($category->subcategory))
            @include('teamview.subCategoryList',['subcategories' => $category->subcategory])
        @endif
            </li>
    @endforeach
</ul>
